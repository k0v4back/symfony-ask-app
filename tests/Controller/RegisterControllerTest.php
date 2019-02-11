<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testShowRegisterForm()
    {
        $client = static::createClient();

        $client->request('GET', '/register');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}