<?php

namespace App\Application\Util\Model;

use App\Application\Util\Enum\AbilityEnum;

final class AbilityScore
{
    private function __construct(
        public AbilityEnum $ability,
        public int $value,
    ) {
    }

    /**
     * @param array<int|string, array<string|int> $arr
     */
    public static function fromArray(array $arr): array
    {
        $returnVal = [];
        foreach ($arr as $key => $value) {
            $returnVal[$key] = self::fromInteger($value['ability'], $value['value']);
        }

        return $returnVal;
    }

    public static function fromInteger(string $ability, int $value): self
    {
        return new self(AbilityEnum::from($ability), $value);
    }

    public function getModifier(): int
    {
        return floor(($this->value - 10) / 2);
    }

    public static function getBase(): array
    {
        $returnVal = [];

        foreach (AbilityEnum::cases() as $value) {
            $returnVal[] = new self($value, 10);
        }

        return $returnVal;
    }
}
