<?php
namespace Jmlamo\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //index
        $crawler = $client->request('GET', '/demo/form');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Form homepage")')->count());
        
        //task form
        $crawler = $client->request('GET', '/demo/form/new');
        $this->assertCount(1, $crawler->filter('form[name=form] > #form'));
        
        
    }
}