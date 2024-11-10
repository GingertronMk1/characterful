<?php

namespace App\Application\Character\Command;

use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;

class CreateCharacterCommand
{
    /**
     * @param Level[] $levels
     * @param string[] $weapons
     * @param string[] $armours
     * @param AbilityScore[] $abilities
     * @param SkillScore[] $skills
     * @param string[] $armour_class
     * @param string[] $saving_throws
     */
    public function __construct(
        public string $name = '',
        public string $species = '',
        public string $species_extra = '',
        public array $levels = [],
        public array $armour_class = [],
        public int $proficiency_bonus = 0,
        public int $speed = 0,
        public int $passive_perception = 0,
        public int $current_hit_points = 0,
        public int $max_hit_points = 0,
        public int $temporary_hit_points = 0,
        public array $weapons = [],
        public array $armours = [],
        public array $abilities = [],
        public array $skills = [],
        public array $saving_throws = [],
        public int $hit_dice_type = 8,
        public int $current_hit_dice = 0,
        public int $max_hit_dice = 0,
    ) {
        if (empty($this->abilities)) {
            $this->abilities = AbilityScore::getBase();
        }

        if (empty($this->skills)) {
            $this->skills = SkillScore::getBase();
        }
        if (empty($this->levels)) {
            $this->levels = [new Level(1, '', '')];
        }
    }
}
