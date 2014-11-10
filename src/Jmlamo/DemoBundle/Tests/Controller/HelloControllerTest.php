<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        //worldAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/world');

        //$this->assertTrue($crawler->filter('html:contains("Hello world, sending new Response")')->count() > 0);
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello world, sending new Response")')->count());
        
        //wizardAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/wizard');
        $this->assertTrue($crawler->filter('html:contains("Hello Harry Poster")')->count() == 1);
        
        //manualrenderingAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/manual-rendering?nameInQueryString=Sanchez');
        $this->assertTrue($crawler->filter('html:contains("Hello Manual Sanchez")')->count() == 1);        
        
        //jsonredirAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/json');
        $this->assertTrue($client->getResponse()->isRedirect('/demo/hello/json/John.json'));
        
        //jsonAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/json/Jack.json');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertRegExp('/{"name":"Jack"}/', $client->getResponse()->getContent());
        
        //godAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello/god');
        //$this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isNotFound());
        
        //indexAction
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/hello');
        $this->assertTrue($client->getResponse()->isRedirect('/demo/hello/John'));
        
        $crawler = $client->request('GET', '/demo/hello/Gill');
        $this->assertTrue($crawler->filter('html:contains("Hello Gill Doe")')->count() == 1);
        
        $crawler = $client->request('GET', '/demo/hello/Gill/Roberts');
        $this->assertTrue($crawler->filter('html:contains("Hello Gill Roberts")')->count() == 1);
        
    }
}
