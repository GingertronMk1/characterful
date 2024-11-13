<?php

namespace App\Infrastructure\Character;

use App\Application\Util\Helpers;
use App\Domain\Character\CharacterEntity;
use App\Domain\Character\CharacterId;
use App\Domain\Character\CharacterRepositoryInterface;
use App\Domain\Util\ClockInterface;
use App\Domain\Util\HelperInterface;
use App\Infrastructure\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

readonly class DbalCharacterRepository extends AbstractDbalRepository implements CharacterRepositoryInterface
{
    private const CHARACTERS_TABLE = 'characters';

    public function __construct(
        private Connection $connection,
        private Helpers $helpers,
        private ClockInterface $clock,
    ) {}

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
                $slug = $initialSlug.'-'.$i;
                ++$i;
            } while (in_array($slug, $slugs));
        }

        $result = $this->storeNewEntity(
            $characterEntity,
            $this->connection,
            self::CHARACTERS_TABLE,
            clock: $this->clock,
            externalServices: [
                HelperInterface::class => $this->helpers,
            ]
        );

        if (1 !== $result) {
            throw new \Exception();
        }

        return $characterEntity->id;
    }

    public function update(CharacterEntity $characterEntity): CharacterId
    {
        $result = $this->updateExistingEntity(
            $characterEntity,
            $this->connection,
            self::CHARACTERS_TABLE,
            clock: $this->clock,
            externalServices: [
                HelperInterface::class => $this->helpers,
            ]
        );
        if (1 !== $result) {
            throw new \Exception((string) $result);
        }

        return $characterEntity->id;
    }
}
