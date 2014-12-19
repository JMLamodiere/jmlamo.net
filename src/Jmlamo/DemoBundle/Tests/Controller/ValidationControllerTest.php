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
        
        //create (name too short -> fails)
        $crawler = $client->request('GET', '/demo/validation/set-name/D');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("too short")'));
        
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
        
        //blank password -> ok
        $crawler = $client->request('GET', '/demo/validation/set-password');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("password is not required")'));
        
        //illegal password
        $crawler = $client->request('GET', '/demo/validation/set-password/Jude');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("cannot match your name")'));
        
        //legal password
        $crawler = $client->request('GET', '/demo/validation/set-password/azerty');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("is legal")'));
        
        //blank password during registration -> fails
        $crawler = $client->request('GET', '/demo/validation/set-registration-password');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("should not be blank")'));
        
        //illegal password during registration
        $crawler = $client->request('GET', '/demo/validation/set-registration-password/Jude');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("cannot match your name")'));
        
        //legal password during registration
        $crawler = $client->request('GET', '/demo/validation/set-registration-password/azerty');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("is legal")'));
        
        //Invalid name and gender
        $crawler = $client->request('GET', '/demo/validation/set-name-and-gender/D/Adams');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("value is too short")'));
        $this->assertCount(0, $crawler->filter('.flash-message:contains("Choose a valid gender")'));
        
        //Valid name but invalid gender
        $crawler = $client->request('GET', '/demo/validation/set-name-and-gender/Jude/Adams');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(0, $crawler->filter('.flash-message:contains("value is too short")'));
        $this->assertCount(1, $crawler->filter('.flash-message:contains("Choose a valid gender")'));
        
        //Valid name and gender
        $crawler = $client->request('GET', '/demo/validation/set-name-and-gender/Jude/male');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("Both rules are valid")'));
        
        //Simple user, no IBAN
        $crawler = $client->request('GET', '/demo/validation/set-iban/0');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("IBAN not required")'));
        
        //Simple user, invalid iban
        $crawler = $client->request('GET', '/demo/validation/set-iban/0/AAA');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("not a valid International Bank Account Number")'));
        
        //Premium user, no IBAN
        $crawler = $client->request('GET', '/demo/validation/set-iban/1');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("IBAN required for premium users")'));
        
        //Premium user, valid iban
        $crawler = $client->request('GET', '/demo/validation/set-iban/1/FR1420041010050500013M02606');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("IBAN ok")'));
        
        //Invalid email
        $crawler = $client->request('GET', '/demo/validation/check-email/221b%20baker%20street');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("Invalid email address")'));
        
        //Valid email format, but invalid domain
        $crawler = $client->request('GET', '/demo/validation/check-email/herlock@sholmes404.net/1');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("code 2")'));
        
        //Same but without domain check
        $crawler = $client->request('GET', '/demo/validation/check-email/herlock@sholmes404.net');
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('.flash-message:contains("email is valid")'));
    }

}
