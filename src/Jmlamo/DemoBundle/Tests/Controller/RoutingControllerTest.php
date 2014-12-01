<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutingControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/routing');
        $this->assertTrue($crawler->filter('html:contains("Routing homepage")')->count() == 1);
        
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
        $this->assertEquals('http', substr($href, 0, 4));
        
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
        $this->assertTrue($crawler->filter('h1:contains("GET method")')->count() == 1);
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
    }
}
