<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TwigControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //index
        $crawler = $client->request('GET', '/demo/twig');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Twig homepage")')->count());
        
        //for
        $crawler = $client->request('GET', '/demo/twig/for');
        $this->assertCount(2, $crawler->filter('li:contains("is even")'));
        
        //1=monday, 2=tuesday
        if (date('N') <=2) {
            $this->assertCount(1, $crawler->filter('html:contains("the week has just started")'));
        } else {
            $this->assertGreaterThan(0, $crawler->filter('li:contains("is a weekend day")')->count());
        }
        
    }

}
