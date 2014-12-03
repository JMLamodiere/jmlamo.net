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
        
        //embedding
        $crawler = $client->request('GET', '/demo/twig/embedding');
        $this->assertCount(5, $crawler->filter('ul#lastDays li'));
        
        //hinclude
        $crawler = $client->request('GET', '/demo/twig/hinclude');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Loading...")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("... NoW lOaDiNg ...")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("PLEASE WAIT !!")')->count());
        
        //assets
        
        //all images must end with this :
        $srcEnd = 'bundles/jmlamodemo/images/beach_400.jpg';
        
        $crawler = $client->request('GET', '/demo/twig/asset');
        //<img> next to "<h2>Relative..."
        $src = $crawler->filter('h2:contains("Relative")')
            ->nextAll()
            ->filter('img')
            ->first()
            ->attr('src');
        //must start with /v3/...
        $this->assertRegExp(
            '#^\/v(\d+)\/#',
            $src
        );
        $this->assertStringEndsWith($srcEnd, $src);
        
        //<img> next to "<h2>Absolute..."
        $src = $crawler->filter('h2:contains("Absolute")')
            ->nextAll()
            ->filter('img')
            ->first()
            ->attr('src');
        //must start with http://
        $this->assertStringStartsWith('http', $src);
        $this->assertStringEndsWith($srcEnd, $src);
        
        //<img> next to "<h2>Individual asset..."
        $src = $crawler->filter('h2:contains("Individual asset")')
            ->nextAll()
            ->filter('img')
            ->first()
            ->attr('src');
        $this->assertEquals('/v2/' . $srcEnd, $src);
    }

}
