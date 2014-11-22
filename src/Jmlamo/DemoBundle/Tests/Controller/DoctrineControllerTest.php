<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctrineControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //index
        $crawler = $client->request('GET', '/demo/doctrine');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Doctrine homepage")')->count());
    }

}
