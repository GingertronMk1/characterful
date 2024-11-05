<?php

namespace App\Infrastructure\Character;

use App\Application\Util\Helpers;
use App\Domain\Character\CharacterEntity;
use App\Domain\Character\CharacterId;
use App\Domain\Character\CharacterRepositoryInterface;
use Doctrine\DBAL\Connection;
use DateTimeImmutable;
use Exception;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class DbalCharacterRepository implements CharacterRepositoryInterface
{
    private const CHARACTERS_TABLE = 'characters';
    public function __construct(
        private Connection   $connection,
        private SluggerInterface $slugger,
        private Helpers $helpers
    )
    {
    }

    public function generateId(): CharacterId
    {
        return CharacterId::generate();
    }

    public function store(CharacterEntity $characterEntity): CharacterId
    {
        $checkQuery = $this->connection->createQueryBuilder();
        $checkQuery->select('*')->from(self::CHARACTERS_TABLE);
        return match ($checkQuery->executeQuery()->rowCount()) {
            0 => $this->create($characterEntity),
            1 => $this->update($characterEntity),
            default => throw new Exception(),
        };
    }

    private function create(CharacterEntity $characterEntity): CharacterId
    {
        $slug = $this->slugger->slug($characterEntity->name);
        $qb = $this->connection->createQueryBuilder();
        $qb->insert(self::CHARACTERS_TABLE)
            ->values([
                'id' => ':id',
                'name' => ':name',
                'slug' => ':slug',
                'levels' => ':levels',
                'armour_class' => ':armour_class',
                'proficiency_bonus' => ':proficiency_bonus',
                'speed' => ':speed',
                'passive_perception' => ':passive_perception',
                'current_hit_points' => ':current_hit_points',
                'max_hit_points' => ':max_hit_points',
                'temporary_hit_points' => ':temporary_hit_points',
                'weapons' => ':weapons',
                'armours' => ':armours',
                'abilities' => ':abilities',
                'skills' => ':skills',
                'saving_throws' => ':saving_throws',
                'hit_dice_type' => ':hit_dice_type',
                'current_hit_dice' => ':current_hit_dice',
                'max_hit_dice' => ':max_hit_dice',
                'created_at' => ':now',
                'updated_at' => ':now',
            ])
            ->setParameters([
                'id' => (string)$characterEntity->id,
                'name' => $characterEntity->name,
                'slug' => $slug,
                'levels' => $this->helpers->jsonEncode($characterEntity->levels),
                'armour_class' => $this->helpers->jsonEncode($characterEntity->armour_class),
                'proficiency_bonus' => $characterEntity->proficiency_bonus,
                'speed' => $characterEntity->speed,
                'passive_perception' => $characterEntity->passive_perception,
                'current_hit_points' => $characterEntity->current_hit_points,
                'max_hit_points' => $characterEntity->max_hit_points,
                'temporary_hit_points' => $characterEntity->temporary_hit_points,
                'weapons' => $this->helpers->jsonEncode($characterEntity->weapons),
                'armours' => $this->helpers->jsonEncode($characterEntity->armours),
                'abilities' => $this->helpers->jsonEncode($characterEntity->abilities),
                'skills' => $this->helpers->jsonEncode($characterEntity->skills),
                'saving_throws' => ':saving_throws',
                'hit_dice_type' => $characterEntity->hit_dice_type,
                'current_hit_dice' => $characterEntity->current_hit_dice,
                'max_hit_dice' => $characterEntity->max_hit_dice,
                'now' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
        if ($qb->executeStatement() !== 1) {
            throw new Exception();
        }
        return $characterEntity->id;
    }


    private function update(CharacterEntity $characterEntity): CharacterId
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->update(self::CHARACTERS_TABLE)
            ->where('id = :id')
            ->values([
                'levels' => ':levels',
                'armour_class' => ':armour_class',
                'proficiency_bonus' => ':proficiency_bonus',
                'speed' => ':speed',
                'passive_perception' => ':passive_perception',
                'current_hit_points' => ':current_hit_points',
                'max_hit_points' => ':max_hit_points',
                'temporary_hit_points' => ':temporary_hit_points',
                'weapons' => ':weapons',
                'armours' => ':armours',
                'abilities' => ':abilities',
                'skills' => ':skills',
                'saving_throws' => ':saving_throws',
                'hit_dice_type' => ':hit_dice_type',
                'current_hit_dice' => ':current_hit_dice',
                'max_hit_dice' => ':max_hit_dice',
                'created_at' => ':now',
                'updated_at' => ':now',
            ])
            ->setParameters([
                'id' => (string)$characterEntity->id,
                'name' => $characterEntity->name,
                'levels' => $this->helpers->jsonEncode($characterEntity->levels),
                'armour_class' => $this->helpers->jsonEncode($characterEntity->armour_class),
                'proficiency_bonus' => $characterEntity->proficiency_bonus,
                'speed' => $characterEntity->speed,
                'passive_perception' => $characterEntity->passive_perception,
                'current_hit_points' => $characterEntity->current_hit_points,
                'max_hit_points' => $characterEntity->max_hit_points,
                'temporary_hit_points' => $characterEntity->temporary_hit_points,
                'weapons' => $this->helpers->jsonEncode($characterEntity->weapons),
                'armours' => $this->helpers->jsonEncode($characterEntity->armours),
                'abilities' => $this->helpers->jsonEncode($characterEntity->abilities),
                'skills' => $this->helpers->jsonEncode($characterEntity->skills),
                'saving_throws' => ':saving_throws',
                'hit_dice_type' => $characterEntity->hit_dice_type,
                'current_hit_dice' => $characterEntity->current_hit_dice,
                'max_hit_dice' => $characterEntity->max_hit_dice,
                'now' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
        if ($qb->executeStatement() !== 1) {
            throw new Exception();
        }
        return $characterEntity->id;
    }
}