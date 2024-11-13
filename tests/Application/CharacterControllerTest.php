<?php

namespace App\Tests\Application;

/**
 * @internal
 *
 * @coversNothing
 */
class CharacterControllerTest extends AbstractApplicationTestCase
{
    private const EXPECTED_SLUG = 'test-character-1';
    private const INITIAL_NAME = 'Test Character 1';
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
            'create_character_form[name]' => self::INITIAL_NAME,
            'create_character_form[species]' => 'Human',
            'create_character_form[species_extra]' => 'Yorkshire',
            'create_character_form[levels][0][class]' => 'Barbarian',
            'create_character_form[levels][0][subClass]' => 'Beserker',
            'create_character_form[levels][0][level]' => 1,
        ]);
        $newCrawler = $this->client->submit($form);
        $this->assertResponseRedirects(
            $this->urlGenerator->generate('character.view', ['slug' => self::EXPECTED_SLUG])
        );
        $h1Text = $newCrawler->filter('h1')->text();
        $this->assertEquals(self::INITIAL_NAME, $h1Text);
    }

    public function testUpdate(): void
    {
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('character.update', ['slug' => self::EXPECTED_SLUG]));
        $this->assertResponseIsSuccessful();
        $form = $crawler->filter('[name=update_character_form]')->form();
    }
}
