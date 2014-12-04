<?php

namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ValidationControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //index
        $crawler = $client->request('GET', '/demo/validation');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Validation homepage")')->count());
        
        //create (blank name -> fails)
        $crawler = $client->request('GET', '/demo/validation/create');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("should not be blank")'));
        
        //create (valid name)
        $crawler = $client->request('GET', '/demo/validation/create/Jude');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("is valid !")'));
    }

}
