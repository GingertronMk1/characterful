<?php

namespace App\Infrastructure;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Common\AbstractMappedEntity;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

abstract readonly class AbstractDbalRepository
{
    /**
     * @param AbstractMappedEntity|array<string, mixed> $entity
     * @param array<string, mixed> $externalServices
     * @throws Exception
     */
    protected function storeNewEntity(
        AbstractMappedEntity|array $entity,
        Connection $connection,
        string $tableName,
        //        ?ClockInterface $clock = null,
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
        $storeQuery
            ->setValue('created_at', ':now')
            ->setValue('updated_at', ':now')
            ->setParameter('now', $this->getNow())
        ;

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
        $storeQuery
            ->set('updated_at', ':now')
            ->setParameter('now', $this->getNow())
        ;

        return (int) $storeQuery->executeStatement();
    }

    private function getNow(): string
    {
        return (new \DateTimeImmutable())->format('Y-m-d H:i:s');
    }
}
