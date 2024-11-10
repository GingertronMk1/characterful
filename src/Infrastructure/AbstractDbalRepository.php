<?php

namespace App\Infrastructure;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Common\AbstractMappedEntity;
use Doctrine\DBAL\Connection;

abstract readonly class AbstractDbalRepository
{
    /**
     * @param array<string, mixed> $externalServices
     */
    protected function storeNewEntity(
        AbstractMappedEntity $entity,
        Connection $connection,
        string $tableName,
        //        ?ClockInterface $clock = null,
        array $externalServices = [],
    ): int {
        $storeQuery = $connection->createQueryBuilder();
        $storeQuery
            ->insert($tableName)
        ;
        foreach ($entity->getMappedData($externalServices) as $column => $value) {
            $storeQuery
                ->setValue($column, ":{$column}")
                ->setParameter($column, $value)
            ;
        }
        //        if ($clock) {
        //            $storeQuery
        //                ->setValue('created_at', ':now')
        //                ->setValue('updated_at', ':now')
        //                ->setParameter('now', (string) $clock->getTime())
        //            ;
        //        }

        return (int) $storeQuery->executeStatement();
    }

    /**
     * @param array<string> $idColumn
     * @param array<string, mixed> $externalServices
     */
    protected function updateExistingEntity(
        AbstractMappedEntity $entity,
        Connection $connection,
        string $tableName,
        //        ?ClockInterface $clock = null,
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
        //        if ($clock) {
        //            $storeQuery
        //                ->set('updated_at', ':now')
        //                ->setParameter('now', (string) $clock->getTime())
        //            ;
        //        }

        return (int) $storeQuery->executeStatement();
    }
}
