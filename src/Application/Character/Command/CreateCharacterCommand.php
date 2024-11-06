<?php

namespace App\Application\Character\Command;

use App\Application\Util\Model\AbilityScore;

class CreateCharacterCommand
{
    public function __construct(
        public string $name = '',
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
        public string $hit_dice_type = '',
        public int $current_hit_dice = 0,
        public int $max_hit_dice = 0,
    ) {
        if (empty($this->abilities)) {
            $this->abilities = AbilityScore::getBase();
        }
    }
}
