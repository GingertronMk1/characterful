<?php

namespace App\Application\Util\Model;

use App\Application\Enum\AbilityEnum;

final class Weapon
{
    public function __construct(
        public string $name = '',
        public AbilityEnum $modifier_ability = AbilityEnum::Strength,
        public int $modifier = 0,
        public int $dice_type = 0,
        public int $dice_count = 0,
    ) {}

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'modifier_ability' => $this->modifier_ability->value,
            'modifier' => $this->modifier,
            'dice_type' => $this->dice_type,
            'dice_count' => $this->dice_count,
        ];
    }
}
