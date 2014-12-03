<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SessionControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/session');
        $this->assertCount(1, $crawler->filter('.flash-message:contains("0 is an even number")'));
        $this->assertCount(1, $crawler->filter('h1:contains("Counter : 0")'));
        
        $crawler = $client->reload();
        $this->assertCount(0, $crawler->filter('.flash-message'));
        $this->assertCount(1, $crawler->filter('h1:contains("Counter : 1")'));
        
        $crawler = $client->request('GET', '/demo/session');
        $this->assertCount(1, $crawler->filter('h1:contains("Counter : 2")'));
        
        $client->restart();
        $crawler = $client->request('GET', '/demo/session');
        $this->assertCount(1, $crawler->filter('h1:contains("Counter : 0")'));
    }

}
