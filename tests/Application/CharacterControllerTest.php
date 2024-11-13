<?php

namespace App\Tests\Application;

/**
 * @internal
 *
 * @coversNothing
 */
class CharacterControllerTest extends AbstractApplicationTestCase
{
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
