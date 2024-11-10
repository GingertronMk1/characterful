<?php

namespace App\Application\Common;

abstract class AbstractMappedModel
{
    /**
     * @param array<string, mixed> $row
     * @param array<string, mixed> $externalServices
     */
    abstract public static function createFromRow(array $row, array $externalServices = []): static;

    /**
     * @param array<string, int|string>|false $row
     * @param array<string, mixed> $externalServices
     * @throws \Exception
     */
    public static function safeCreateFromRow(array|false $row, array $externalServices = []): static
    {
        if (false === $row) {
            throw new \Exception();
        }

        return static::createFromRow($row, $externalServices);
    }

    /**
     * @param array<string, mixed> $externalServices
     * @param array<string> $expectedServiceNames
     */
    protected static function checkServicesExist(array $externalServices, array $expectedServiceNames): bool
    {
        $externalServiceNames = array_keys($externalServices);
        $diff = array_diff($expectedServiceNames, $externalServiceNames);
        if (!empty($diff)) {
            $diffString = implode(', ', $diff);

            throw new \InvalidArgumentException("`{$diffString}` missing from external services");
        }

        return true;
    }
}
