<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create');

        $this->assertResponseIsSuccessful();
    }
}