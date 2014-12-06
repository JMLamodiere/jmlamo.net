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
        $crawler = $client->request('GET', '/demo/validation/set-name');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("should not be blank")'));
        
        //create (valid name- > ok)
        $crawler = $client->request('GET', '/demo/validation/set-name/Jude');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("is valid !")'));
        
        //create (blank gender -> ok)
        $crawler = $client->request('GET', '/demo/validation/set-gender');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("gender is not required")'));
        
        //create (weird gender -> not ok)
        $crawler = $client->request('GET', '/demo/validation/set-gender/Adams');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("Choose a valid gender")'));
        
        //create (valid gender -> ok)
        $crawler = $client->request('GET', '/demo/validation/set-gender/male');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("is valid !")'));
    }

}
