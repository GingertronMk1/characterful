<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class CharacterControllerTest extends WebTestCase
{
    private UrlGeneratorInterface $urlGenerator;
    private HttpKernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $container->get(UrlGeneratorInterface::class);
        $this->urlGenerator = $urlGenerator;
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

        $form = $crawler->filter('[name=create_character_form]')->form();
        $form->setValues([
            'create_character_form[name]' => 'Test Character 1',
            'create_character_form[species]' => 'Human',
            'create_character_form[species_extra]' => 'Yorkshire',
            'create_character_form[levels][0][class]' => 'Barbarian',
            'create_character_form[levels][0][subClass]' => 'Beserker',
            'create_character_form[levels][0][level]' => 1,
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects(
            $this->urlGenerator->generate('character.view', ['slug' => 'test-character-1'])
        );
    }
}
