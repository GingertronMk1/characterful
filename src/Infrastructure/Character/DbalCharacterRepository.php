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
        private Helpers $helpers
    )
    {
    }

    public function generateId(): CharacterId
    {
        return CharacterId::generate();
    }

    public function create(CharacterEntity $characterEntity): CharacterId
    {
        $initialSlug = $this->helpers->slug($characterEntity->name);
        $slugExistsQuery = $this->connection->createQueryBuilder();
        $slugExistsQuery
            ->select('slug')
            ->from(self::CHARACTERS_TABLE)
            ->where('slug LIKE :slug')
            ->setParameter('slug', "%{$initialSlug}%")
        ;

        $slugs = $slugExistsQuery->fetchFirstColumn();
        $slug = $initialSlug;
        if (in_array($slug, $slugs)) {
            $i = 1;
            do {
                $slug = $initialSlug . '-' . $i;
                $i++;
            } while (in_array($slug, $slugs));
        }

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


    public function update(CharacterEntity $characterEntity): CharacterId
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->update(self::CHARACTERS_TABLE)
            ->where('id = :id')
            ->set('levels', ':levels')
            ->set('armour_class', ':armour_class')
            ->set('proficiency_bonus', ':proficiency_bonus')
            ->set('speed', ':speed')
            ->set('passive_perception', ':passive_perception')
            ->set('current_hit_points', ':current_hit_points')
            ->set('max_hit_points', ':max_hit_points')
            ->set('temporary_hit_points', ':temporary_hit_points')
            ->set('weapons', ':weapons')
            ->set('armours', ':armours')
            ->set('abilities', ':abilities')
            ->set('skills', ':skills')
            ->set('saving_throws', ':saving_throws')
            ->set('hit_dice_type', ':hit_dice_type')
            ->set('current_hit_dice', ':current_hit_dice')
            ->set('max_hit_dice', ':max_hit_dice')
            ->set('created_at', ':now')
            ->set('updated_at', ':now')
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
        $result = $qb->executeStatement();
        if ($result !== 1) {
            throw new Exception($result);
        }
        return $characterEntity->id;
    }
}