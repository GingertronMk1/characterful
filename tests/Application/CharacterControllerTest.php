<?php

namespace App\Tests\Application;

use Symfony\Component\DomCrawler\Field\FormField;

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

        $form = $crawler->filter('form[name=create_character_form]')->form();
        $form->setValues([
            'create_character_form[name]' => self::INITIAL_NAME,
            'create_character_form[species]' => 'Human',
            'create_character_form[species_extra]' => 'Yorkshire',
            'create_character_form[levels][0][class]' => 'Barbarian',
            'create_character_form[levels][0][subClass]' => 'Beserker',
            'create_character_form[levels][0][level]' => 1,
        ]);
        $this->client->submit($form);

        $expectedUrl = $this->getExpectedUrl();

        $this->assertResponseRedirects($expectedUrl);
        $newCrawler = $this->client->request('GET', $expectedUrl);
        $h1Text = $newCrawler->filter('h1')->text();
        $this->assertEquals(self::INITIAL_NAME, $h1Text);
    }

    public function testUpdate(): void
    {
        $crawler = $this->client->request('GET', $this->urlGenerator->generate('character.update', ['slug' => self::EXPECTED_SLUG]));
        $this->assertResponseIsSuccessful();
        $form = $crawler->filter('form[name=update_character_form]')->form();

        $nthSkill = 0;
        $nthSkillArrayItem = "update_character_form[skills][{$nthSkill}]";

        $newProficiencySkillField = $form->get("{$nthSkillArrayItem}[skill]");

        if (!$newProficiencySkillField instanceof FormField) {
            $this->fail("Should only be one form field for selector '{$nthSkillArrayItem}'.");
        }

        $newProficiencySkill = $newProficiencySkillField->getValue();

        if (!is_string($newProficiencySkill)) {
            $this->fail("Should only be one form field for selector '{$nthSkillArrayItem}'.");
        }

        $form->setValues([
            "{$nthSkillArrayItem}[proficiencies]" => 1,
        ]);
        $this->client->submit($form);

        $expectedUrl = $this->getExpectedUrl();

        $this->assertResponseRedirects($expectedUrl);
        $newCrawler = $this->client->request('GET', $expectedUrl);
        $this->assertStringContainsString(
            "{$newProficiencySkill} 1",
            $newCrawler->text()
        );
    }

    private function getExpectedUrl(): string
    {
        return $this->urlGenerator->generate('character.view', ['slug' => self::EXPECTED_SLUG]);
    }
}
