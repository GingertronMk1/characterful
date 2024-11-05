<?php

namespace App\Application\Character;

use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Domain\Character\CharacterId;
use DateTimeInterface;

class CharacterModel
{
    /**
     * @param CharacterId $id
     * @param string $name
     * @param string $slug
     * @param Level[] $levels
     * @param array $armour_class
     * @param int $proficiency_bonus
     * @param int $speed
     * @param int $passive_perception
     * @param int $current_hit_points
     * @param int $max_hit_points
     * @param int $temporary_hit_points
     * @param array $weapons
     * @param array $armours
     * @param AbilityScore[] $abilities
     * @param array $skills
     * @param array $saving_throws
     * @param string $hit_dice_type
     * @param int $current_hit_dice
     * @param int $max_hit_dice
     * @param DateTimeInterface $created_at
     * @param DateTimeInterface $updated_at
     * @param DateTimeInterface|null $deleted_at
     */
    public function __construct(
        public CharacterId $id,
        public string $name,
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
        public string $hit_dice_type,
        public int $current_hit_dice,
        public int $max_hit_dice,
        public \DateTimeInterface $created_at,
        public \DateTimeInterface $updated_at,
        public ?\DateTimeInterface $deleted_at,
    ) {}

    public function getMainClass(): ?Level
    {
        if (!count($this->levels)) {
            return null;
        }

        return array_values($this->levels)[0];
    }
}