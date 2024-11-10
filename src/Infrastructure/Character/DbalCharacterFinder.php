<?php

namespace App\Infrastructure\Character;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\CharacterModel;
use App\Application\Util\Helpers;
use App\Domain\Character\CharacterId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;

readonly class DbalCharacterFinder implements CharacterFinderInterface
{
    public function __construct(
        private Connection $connection,
        private Helpers $helpers,
    ) {}

    /**
     * @throws Exception
     */
    public function findBySlug(string $slug): CharacterModel
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->where('slug = :slug')
            ->setParameter('slug', $slug)
        ;

        $row = $qb->fetchAssociative();

        return CharacterModel::safeCreateFromRow($row, [Helpers::class => $this->helpers]);
    }

    /**
     * @throws Exception
     */
    public function findById(CharacterId $id): CharacterModel
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->where('id = :id')
            ->setParameter('id', (string) $id)
        ;

        $row = $qb->fetchAssociative();

        return CharacterModel::safeCreateFromRow($row, [Helpers::class => $this->helpers]);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function all(): array
    {
        $qb = $this->getQueryBuilder();

        return array_map(
            fn (array $row) => CharacterModel::safeCreateFromRow($row, [Helpers::class => $this->helpers]),
            $qb->fetchAllAssociative(),
        );
    }

    private function getQueryBuilder(): QueryBuilder
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('characters')
            ->orderBy('id')
        ;

        return $qb;
    }
}
