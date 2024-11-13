<?php

namespace App\Application\Character;

use App\Application\Common\AbstractMappedModel;
use App\Application\Enum\AbilityEnum;
use App\Application\Enum\SkillEnum;
use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Application\Util\Model\Weapon;
use App\Domain\Character\CharacterId;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Util\HelperInterface;

final class CharacterModel extends AbstractMappedModel
{
    /**
     * @param Level[] $levels
     * @param Weapon[] $weapons
     * @param string[] $armours
     * @param AbilityScore[] $abilities
     * @param SkillScore[] $skills
     * @param string[] $armour_class
     * @param string[] $saving_throws
     */
    public function __construct(
        public CharacterId $id,
        public string $name,
        public string $species,
        public string $species_extra,
        public string $slug,
        public array $levels,
        public array $armour_class,
        public int $proficiency_bonus,
        public int $speed,
        public int $passive_perception,
        public int $current_hit_points,
        public int $max_hit_points,
        public int $temporary_hit_points,
        public array $weapons,
        public array $armours,
        public array $abilities,
        public array $skills,
        public array $saving_throws,
        public int $hit_dice_type,
        public int $current_hit_dice,
        public int $max_hit_dice,
        public DateTime $created_at,
        public DateTime $updated_at,
        public ?DateTime $deleted_at,
    ) {}

    public static function createFromRow(array $row, array $externalServices = []): static
    {
        [
            HelperInterface::class => $helpers,
        ] = $externalServices;

        $levels = array_map(
            fn (array $row) => new Level($row['level'], $row['class'], $row['subClass']),
            $helpers->jsonDecode($row['levels']),
        );
        usort($levels, fn ($a, $b) => $a->level - $b->level);

        $createdAt = DateTime::fromString($row['created_at']);
        $updatedAt = DateTime::fromString($row['updated_at']);
        $deletedAt = $row['deleted_at'] ? DateTime::fromString($row['updated_at']) : null;

        $weapons = array_map(
            fn (array $weaponArr) => new Weapon(
                name: $weaponArr['name'],
                modifier_ability: AbilityEnum::from($weaponArr['modifier_ability']),
                modifier: $weaponArr['modifier'],
                dice_type: $weaponArr['dice_type'],
                dice_count: $weaponArr['dice_count'],
            ),
            $helpers->jsonDecode($row['weapons']),
        );

        return new self(
            id: CharacterId::fromString($row['id']),
            name: $row['name'],
            species: $row['species'],
            species_extra: $row['species_extra'],
            slug: $row['slug'],
            levels: $levels,
            armour_class: $helpers->jsonDecode($row['armour_class']),
            proficiency_bonus: (int) $row['proficiency_bonus'],
            speed: (int) $row['speed'],
            passive_perception: (int) $row['passive_perception'],
            current_hit_points: (int) $row['current_hit_points'],
            max_hit_points: (int) $row['max_hit_points'],
            temporary_hit_points: (int) $row['temporary_hit_points'],
            weapons: $weapons,
            armours: $helpers->jsonDecode($row['armours']),
            abilities: AbilityScore::fromArray($helpers->jsonDecode($row['abilities'])),
            skills: SkillScore::fromArray($helpers->jsonDecode($row['skills'])),
            saving_throws: $helpers->jsonDecode($row['saving_throws']),
            hit_dice_type: $row['hit_dice_type'],
            current_hit_dice: (int) $row['current_hit_dice'],
            max_hit_dice: (int) $row['max_hit_dice'],
            created_at: $createdAt,
            updated_at: $updatedAt,
            deleted_at: $deletedAt,
        );
    }

    public function getMainClass(): ?Level
    {
        if (!count($this->levels)) {
            return null;
        }

        return array_values($this->levels)[0];
    }

    public function getSkillModifier(SkillEnum $skill): int
    {
        $ability = $skill->getAbilityEnum();
        $abilityScore = $this->getAbilityScore($ability);
        $abilityModifier = $abilityScore?->getModifier() ?? 0;

        $skillScore = $this->getSkillScore($skill);
        $skillModifier = $this->proficiency_bonus * ($skillScore?->proficiencies ?? 0);

        return $abilityModifier + $skillModifier;
    }

    public function getAbilityScore(AbilityEnum $ability): ?AbilityScore
    {
        foreach ($this->abilities as $thisAbility) {
            if ($thisAbility->ability === $ability) {
                return $thisAbility;
            }
        }

        return null;
    }

    public function getSkillScore(SkillEnum $skill): ?SkillScore
    {
        foreach ($this->skills as $thisSkill) {
            if ($thisSkill->skill === $skill) {
                return $thisSkill;
            }
        }

        return null;
    }
}
