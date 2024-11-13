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
