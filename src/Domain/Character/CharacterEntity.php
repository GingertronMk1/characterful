<?php

namespace App\Domain\Character;

use App\Domain\Common\ValueObject\AbstractUuidId;

readonly class CharacterEntity
{
    /**
     * @param CharacterId $id
     * @param string $name
     * @param array $levels
     * @param array $armour_class
     * @param int $proficiency_bonus
     * @param int $speed
     * @param int $passive_perception
     * @param int $current_hit_points
     * @param int $max_hit_points
     * @param int $temporary_hit_points
     * @param array $weapons
     * @param array $armours
     * @param array $abilities
     * @param array $skills
     * @param array $saving_throws
     * @param string $hit_dice_type
     * @param int $current_hit_dice
     * @param int $max_hit_dice
     */
    public function __construct(
        public CharacterId $id,
        public string $name,
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
        public string $hit_dice_type,
        public int $current_hit_dice,
        public int $max_hit_dice,
    ) {}
}