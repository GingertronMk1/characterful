<?php

namespace App\Application\Util\Model;

use App\Application\Enum\AbilityEnum;

final class AbilityScore
{
    public function __construct(
        public AbilityEnum $ability,
        public int $value,
    ) {}

    public function getModifier(): int
    {
        return (int) floor(($this->value - 10) / 2);
    }

    /**
     * @param array<self> $mergeWith
     *
     * @return array<self>
     */
    public static function getBase(array $mergeWith = []): array
    {
        $returnVal = [];

        foreach (AbilityEnum::cases() as $value) {
            foreach ($mergeWith as $mergeValue) {
                if ($mergeValue->ability === $value) {
                    $returnVal[] = $mergeValue;

                    continue 2;
                }
            }
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
