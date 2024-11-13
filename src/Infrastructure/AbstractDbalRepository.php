<?php

namespace App\Infrastructure;

use App\Domain\Common\AbstractMappedEntity;
use App\Domain\Util\ClockInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

abstract readonly class AbstractDbalRepository
{
    /**
     * @param AbstractMappedEntity|array<string, mixed> $entity
     * @param array<string, mixed> $externalServices
     *
     * @throws Exception
     */
    protected function storeNewEntity(
        AbstractMappedEntity|array $entity,
        Connection $connection,
        string $tableName,
        ?ClockInterface $clock = null,
        array $externalServices = [],
    ): int {
        $storeQuery = $connection->createQueryBuilder();
        $storeQuery
            ->insert($tableName)
        ;

        $mappedData = $entity instanceof AbstractMappedEntity
            ? $entity->getMappedData($externalServices)
            : $entity;

        foreach ($mappedData as $column => $value) {
            $storeQuery
                ->setValue($column, ":{$column}")
                ->setParameter($column, $value)
            ;
        }
        if ($clock) {
            $storeQuery
                ->setValue('created_at', ':now')
                ->setValue('updated_at', ':now')
                ->setParameter('now', (string) $clock->now())
            ;
        }

        return $storeQuery->executeStatement();
    }

    /**
     * @param array<string> $idColumn
     * @param array<string, mixed> $externalServices
     */
    protected function updateExistingEntity(
        AbstractMappedEntity $entity,
        Connection $connection,
        string $tableName,
        ?ClockInterface $clock = null,
        array $idColumn = ['id'],
        array $externalServices = []
    ): int {
        $entityMappedData = $entity->getMappedData($externalServices);
        $storeQuery = $connection->createQueryBuilder();
        $storeQuery
            ->update($tableName)
        ;
        foreach ($idColumn as $colKey => $col) {
            $storeQuery
                ->andWhere("{$col} = :id{$colKey}")
                ->setParameter("id{$colKey}", $entityMappedData[$col])
            ;
        }

        foreach ($entityMappedData as $column => $value) {
            $storeQuery
                ->set($column, ":{$column}")
                ->setParameter($column, $value)
            ;
        }
        if ($clock) {
            $storeQuery
                ->set('updated_at', ':now')
                ->setParameter('now', (string) $clock->now())
            ;
        }

        return $storeQuery->executeStatement();
    }
}
