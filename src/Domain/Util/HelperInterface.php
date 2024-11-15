<?php

namespace App\Domain\Util;

interface HelperInterface
{
    public function jsonEncode(mixed $data, mixed ...$options): string;

    /**
     * @return array<string, mixed>
     */
    public function jsonDecode(string|\Stringable $data, mixed ...$options): array;

    public function slug(string|\Stringable $sluggee): string;

    public function roll(int $diceType, int $diceCount = 1): int;
}
