<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RandomControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/random/2');
        $this->assertCount(1, $crawler->filter('html:contains("Limit given : 2")'));
        $this->assertRegExp('/Result : [1-2]/', $client->getResponse()->getContent());
    }

}
