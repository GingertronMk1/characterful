<?php

namespace App\Application\Util\Model;

use App\Application\Enum\AbilityEnum;

final class Weapon
{
    public function __construct(
        public string $name,
        public AbilityEnum $modifier_ability,
        public int $modifier,
        public int $dice_type,
        public int $dice_count
    ) {}
}