<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testShowRegisterForm()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testSecuredHello()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertSame('Вход', $crawler->filter('h5')->text());
    }
}