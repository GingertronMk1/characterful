<?php

namespace App\Application\Util\Model;

use App\Application\Enum\AbilityEnum;

final class AbilityScore
{
    private function __construct(
        public AbilityEnum $ability,
        public int $value,
    ) {}

    /**
     * @param array<int|string, array<int|string>> $arr
     *
     * @return array<self>
     */
    public static function fromArray(array $arr): array
    {
        $returnVal = [];
        foreach ($arr as $key => $value) {
            $returnVal[$key] = self::fromInteger((string) $value['ability'], (int) $value['value']);
        }

        return $returnVal;
    }

    public static function fromInteger(string $ability, int $value): self
    {
        return new self(AbilityEnum::from($ability), $value);
    }

    public function getModifier(): int
    {
        return (int) floor(($this->value - 10) / 2);
    }

    /**
     * @return array<self>
     */
    public static function getBase(): array
    {
        $returnVal = [];

        foreach (AbilityEnum::cases() as $value) {
            $returnVal[] = new self($value, 10);
        }

        return $returnVal;
    }

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'ability' => $this->ability->value,
            'value' => $this->value,
        ];
    }
}
