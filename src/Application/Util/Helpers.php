<?php

namespace App\Application\Util;

use App\Domain\Util\HelperInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class Helpers implements HelperInterface
{
    public function __construct(
        private KernelInterface $kernel,
        private SluggerInterface $slugger,
    ) {}

    public function jsonEncode(mixed $data, mixed ...$options): string
    {
        if ($this->kernel->isDebug()) {
            $options['flags'] = ($options['flags'] ?? null) | JSON_PRETTY_PRINT;
        }

        $value = json_encode($data, ...$options);

        return $value ? $value : '[]';
    }

    /**
     * @return array<int|string, mixed>
     */
    public function jsonDecode(string|\Stringable $data, mixed ...$options): array
    {
        $options['associative'] ??= true;

        return json_decode((string) $data, ...$options) ?? [];
    }

    public function slug(string|\Stringable $sluggee): string
    {
        return $this->slugger->slug(strtolower(trim((string) $sluggee)));
    }
}
