<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NotificationControllerTest extends WebTestCase
{
    public function testResponse200(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/notifications/1');

        $this->assertResponseIsSuccessful();
    }
}
