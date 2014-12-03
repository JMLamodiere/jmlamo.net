<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutingControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/routing');
        $this->assertCount(1, $crawler->filter('html:contains("Routing homepage")'));
        
        $link = $crawler->filter('a:contains("Page 2")')->eq(0)->link();
        $crawler = $client->click($link);
        
        $this->assertEquals('/demo/routing/2', $client->getRequest()->getRequestUri());
        
        $crawler = $client->back();
        $this->assertEquals('/demo/routing', $client->getRequest()->getRequestUri());
        
        //@see Symfony\Component\DomCrawler\Crawler
        $relativeLinkNode = $crawler->filter('a:contains("Relative link")')->first();
        $href = $relativeLinkNode->attr('href');
        //relative url starts with a "/"
        $this->assertEquals('/', substr($href, 0, 1));
        $this->assertEquals('demo/routing/my-blog-post', substr($href, strpos($href, 'demo')));
        
        $absoluteLinkNode = $crawler->filter('a:contains("Absolute link")')->first();
        $href = $absoluteLinkNode->attr('href');
        //absolute url starts with "http(s)://"
        $this->assertStringStartsWith('http', $href);
        
        //relative and absolute link lead to the same page
        //@see Symfony\Component\DomCrawler\Link
        $this->assertEquals($relativeLinkNode->link()->getUri(), $absoluteLinkNode->link()->getUri());
        
        $crawler = $client->click($relativeLinkNode->link());
        $this->assertEquals('/demo/routing/my-blog-post', $client->getRequest()->getRequestUri());
        $this->assertTrue($crawler->filter('html:contains("Routing show")')->count() == 1);
        
        $crawler = $client->request('GET', '/demo/routing/browser');
        $this->assertTrue($crawler->filter('h1:contains("User-Agent detection")')->count() == 1);
        //this virtual user-agent is not chrome
        $this->assertTrue($crawler->filter('html:contains("You are not using chrome")')->count() == 1);
        
        //we fake a chrome browser
        $chromeClient = static::createClient(array(), array(
            'HTTP_USER_AGENT' => 'Chrome/fake',
        ));
        $crawler = $chromeClient->request('GET', '/demo/routing/browser');
        $this->assertTrue($crawler->filter('html:contains("You are using chrome")')->count() == 1);
        unset($chromeClient);
        
        $crawler = $client->request('GET', '/demo/routing/contact');
        $node = $crawler->filter('dl:contains("Last name received") > dd');
        $this->assertEquals($node->text(), 'none');
        //@see Symfony\Component\DomCrawler\Form
        $form = $crawler->selectButton('OK')->form();
        $this->assertEquals('POST', $form->getMethod());
        
        //set field value
        $form['name'] = 'Théo';
        //check values about to be submited
        $values = $form->getValues();
        $this->assertEquals('Théo', $values['name']);
        
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect('/demo/routing/contact'));
        //redirection not followed by default, manual call needed :
        $crawler = $client->followRedirect();
        $node = $crawler->filter('dl:contains("Last name received") > dd');
        $this->assertEquals($node->text(), 'Théo');
        $this->assertTrue($crawler->filter('.flash-message:contains("Form data received")')->count() == 1);
        
        //link to html format
        $crawler = $client->request('GET', '/demo/routing');
        $link = $crawler->filter('a:contains("html format")')->first()->link();
        $uri = $link->getUri();
        $this->assertEquals('routing/year', substr($uri, strlen($uri) - 12));
        
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('dd:contains("' . date('Y') . '")')->count() == 1);
        
        //link to json format
        $crawler = $client->back();
        $link = $crawler->filter('a:contains("json format")')->first()->link();
        $uri = $link->getUri();
        $this->assertEquals('routing/year.json', substr($uri, strlen($uri) - 17));
        
        $client->click($link);
        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type',
            'application/json'
        ));
        $this->assertEquals('{"year":"' . date('Y') . '"}', $client->getResponse()->getContent());
    }
}
