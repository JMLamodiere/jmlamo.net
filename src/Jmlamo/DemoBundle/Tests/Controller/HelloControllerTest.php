<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
    
        //indexAction
        $crawler = $client->request('GET', '/demo/hello');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello homepage")')->count());
    
        //worldAction
        $crawler = $client->request('GET', '/demo/hello/world');
        //$this->assertTrue($crawler->filter('html:contains("Hello world, sending new Response")')->count() > 0);
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello world, sending new Response")')->count());
        
        //wizardAction
        $crawler = $client->request('GET', '/demo/hello/wizard');
        $this->assertCount(1, $crawler->filter('html:contains("Hello Harry Poster")'));
        
        //manualrenderingAction
        $crawler = $client->request('GET', '/demo/hello/manual-rendering?nameInQueryString=Sanchez');
        $this->assertCount(1, $crawler->filter('html:contains("Hello Manual Sanchez")'));        
        
        //jsonredirAction
        $crawler = $client->request('GET', '/demo/hello/json');
        $this->assertTrue($client->getResponse()->isRedirect('/demo/hello/json/John.json'));
        
        //jsonAction
        $crawler = $client->request('GET', '/demo/hello/json/Jack.json');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertRegExp('/{"name":"Jack"}/', $client->getResponse()->getContent());
        
        //godAction
        $crawler = $client->request('GET', '/demo/hello/god');
        //$this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isNotFound());
        
        //nameAction
        $crawler = $client->request('GET', '/demo/hello/Gill');
        $this->assertTrue($crawler->filter('html:contains("Hello Gill Doe")')->count() == 1);
        
        $crawler = $client->request('GET', '/demo/hello/Gill/Roberts');
        $this->assertTrue($crawler->filter('html:contains("Hello Gill Roberts")')->count() == 1);
        
    }
}
