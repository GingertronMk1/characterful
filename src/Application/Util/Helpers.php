<?php

namespace App\Application\Util;

use Symfony\Component\HttpKernel\KernelInterface;

readonly class Helpers
{
    public function __construct(
        private KernelInterface $kernel
    ){}

    public function jsonEncode(mixed $data, ...$options): string
    {
        if ($this->kernel->isDebug()) {
            $options['flags'] = ($options['flags'] ?? null) | JSON_PRETTY_PRINT;
        }
        return json_encode($data, ...$options);
    }

    public function jsonDecode(string|\Stringable $data, ...$options): array
    {
        $options['associative'] ??= true;
        return json_decode((string) $data, ...$options) ?? [];
    }
}