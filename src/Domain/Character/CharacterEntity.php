<?php

namespace App\Domain\Character;

use App\Domain\Common\ValueObject\AbstractUuidId;

readonly class CharacterEntity
{
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