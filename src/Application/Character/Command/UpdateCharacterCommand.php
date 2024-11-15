<?php

namespace App\Application\Character\Command;

use App\Application\Character\CharacterModel;
use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Application\Util\Model\Weapon;
use App\Domain\Character\CharacterId;

class UpdateCharacterCommand
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
        public CharacterId $characterId,
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
    ) {}

    public static function fromModel(CharacterModel $model): self
    {
        return new self(
            characterId: $model->id,
            name: $model->name,
            species: $model->species,
            species_extra: $model->species_extra,
            slug: $model->slug,
            levels: $model->levels,
            armour_class: $model->armour_class,
            proficiency_bonus: $model->proficiency_bonus,
            speed: $model->speed,
            passive_perception: $model->passive_perception,
            current_hit_points: $model->current_hit_points,
            max_hit_points: $model->max_hit_points,
            temporary_hit_points: $model->temporary_hit_points,
            weapons: $model->weapons,
            armours: $model->armours,
            abilities: $model->abilities,
            skills: $model->skills,
            saving_throws: $model->saving_throws,
            hit_dice_type: $model->hit_dice_type,
            current_hit_dice: $model->current_hit_dice,
            max_hit_dice: $model->max_hit_dice,
        );
    }
}
