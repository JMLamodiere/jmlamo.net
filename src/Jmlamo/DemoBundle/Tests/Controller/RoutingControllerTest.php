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
        
        $this->assertTrue('/demo/routing/2' == $client->getRequest()->getRequestUri());
    }
}
