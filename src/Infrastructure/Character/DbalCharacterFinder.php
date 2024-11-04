<?php

namespace App\Infrastructure\Character;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\CharacterModel;
use App\Application\Util\AbilityScore;
use App\Domain\Character\CharacterId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

readonly class DbalCharacterFinder implements CharacterFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {}

    public function findBySlug(string $slug): CharacterModel
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->where('slug = :slug')
            ->setParameter('slug', $slug)
        ;

        $row = $qb->fetchAssociative();
        return $this->createFromRow($row);
    }

    public function findById(CharacterId $id): CharacterModel
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->where('id = :id')
            ->setParameter('id', (string) $id)
        ;

        $row = $qb->fetchAssociative();
        return $this->createFromRow($row);
    }

    public function all(): array
    {
        $qb = $this->getQueryBuilder();
        return array_map(
            $this->createFromRow(...),
            $qb->fetchAllAssociative()
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
    private function createFromRow(array $row): CharacterModel
    {
        return new CharacterModel(
            id: CharacterId::fromString($row['id']),
            name: $row['name'],
            slug: $row['slug'],
            levels: json_decode($row['levels'], true),
            armour_class: json_decode($row['armour_class'], true),
            proficiency_bonus: (int) $row['proficiency_bonus'],
            speed: (int) $row['speed'],
            passive_perception: (int) $row['passive_perception'],
            current_hit_points: (int) $row['current_hit_points'],
            max_hit_points: (int) $row['max_hit_points'],
            temporary_hit_points: (int) $row['temporary_hit_points'],
            weapons: json_decode($row['weapons'], true),
            armours: json_decode($row['armours'], true),
            abilities: AbilityScore::fromArray(json_decode($row['abilities'], true)),
            skills: json_decode($row['skills'], true),
            saving_throws: json_decode($row['saving_throws'], true),
            hit_dice_type: $row['hit_dice_type'],
            current_hit_dice: (int) $row['current_hit_dice'],
            max_hit_dice: (int) $row['max_hit_dice'],
            created_at: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['created_at']),
            updated_at: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['updated_at']),
            deleted_at: $row['deleted_at'] ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['updated_at']) : null
        );
    }
}