<?php

namespace App\Application\Util;

final readonly class AbilityScore
{
    private function __construct(
        public int $value
    ) {}

    public static function fromInteger(int $value): self
    {
        return new self($value);
    }

    public function getModifier(): int
    {
        return floor(($this->value - 10) / 2);
    }
}