<?php

namespace App\Domain\Common;

abstract readonly class AbstractMappedEntity
{
    /**
     * @param array<string, mixed> $externalServices
     *
     * @return array<string, int|string>
     */
    abstract public function getMappedData(array $externalServices = []): array;

    /**
     * @param array<string, mixed> $services
     *
     * @throws \Exception
     */
    public function getServiceIfExists(string $service, array $services): mixed
    {
        return $services[$service] ?? throw new \Exception("Service {$service} not found");
    }
}
