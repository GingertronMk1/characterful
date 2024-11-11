<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CharacterControllerTest extends WebTestCase
{
    private UrlGeneratorInterface $urlGenerator;
    private HttpKernelBrowser $client;
    public function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->urlGenerator = $container->get(UrlGeneratorInterface::class);
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('character.index'));

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('character.create'));

        $this->assertResponseIsSuccessful();
    }
}