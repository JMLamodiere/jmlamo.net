<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RandomControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/random/2');
        $this->assertTrue($crawler->filter('html:contains("Limit given : 2")')->count() == 1);
        $this->assertRegExp('/Result : [1-2]/', $client->getResponse()->getContent());
    }

}
