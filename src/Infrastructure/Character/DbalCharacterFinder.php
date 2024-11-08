<?php

namespace App\Infrastructure\Character;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\CharacterModel;
use App\Application\Util\Helpers;
use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Domain\Character\CharacterId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

readonly class DbalCharacterFinder implements CharacterFinderInterface
{
    public function __construct(
        private Connection $connection,
        private Helpers $helpers,
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

    /**
     * @param array<string, mixed>|false $row
     *
     * @throws \Exception
     */
    private function createFromRow(array|false $row): CharacterModel
    {
        if (false === $row) {
            throw new \Exception();
        }
        $levels = array_map(
            fn (array $row) => new Level($row['level'], $row['class'], $row['subClass']),
            $this->helpers->jsonDecode($row['levels']),
        );
        usort($levels, fn ($a, $b) => $a->level - $b->level);

        $createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['created_at']);
        $updatedAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['updated_at']);
        $deletedAt = $row['deleted_at'] ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['updated_at']) : null;

        if (false === $createdAt || false === $updatedAt || false === $deletedAt) {
            throw new \Exception('Invalid date');
        }

        return new CharacterModel(
            id: CharacterId::fromString($row['id']),
            name: $row['name'],
            species: $row['species'],
            species_extra: $row['species_extra'],
            slug: $row['slug'],
            levels: $levels,
            armour_class: $this->helpers->jsonDecode($row['armour_class']),
            proficiency_bonus: (int) $row['proficiency_bonus'],
            speed: (int) $row['speed'],
            passive_perception: (int) $row['passive_perception'],
            current_hit_points: (int) $row['current_hit_points'],
            max_hit_points: (int) $row['max_hit_points'],
            temporary_hit_points: (int) $row['temporary_hit_points'],
            weapons: $this->helpers->jsonDecode($row['weapons']),
            armours: $this->helpers->jsonDecode($row['armours']),
            abilities: AbilityScore::fromArray($this->helpers->jsonDecode($row['abilities'])),
            skills: SkillScore::fromArray($this->helpers->jsonDecode($row['skills'])),
            saving_throws: $this->helpers->jsonDecode($row['saving_throws']),
            hit_dice_type: $row['hit_dice_type'],
            current_hit_dice: (int) $row['current_hit_dice'],
            max_hit_dice: (int) $row['max_hit_dice'],
            created_at: $createdAt,
            updated_at: $updatedAt,
            deleted_at: $deletedAt,
        );
    }
}
