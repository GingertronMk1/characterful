<?php

namespace App\Application\Util;

final readonly class AbilityScore
{
    private function __construct(
        public int $value
    ) {}

    /**
     * @param array<int|string, int> $arr
     */
    public static function fromArray(array $arr): array
    {
        $returnVal = [];
        foreach($arr as $key => $value) {
            $returnVal[$key] = self::fromInteger($value);
        }
        return $returnVal;
    }

    public static function fromInteger(int $value): self
    {
        return new self($value);
    }

    public function getModifier(): int
    {
        return floor(($this->value - 10) / 2);
    }
}