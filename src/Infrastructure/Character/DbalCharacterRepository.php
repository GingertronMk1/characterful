<?php

namespace App\Infrastructure\Character;

use App\Domain\Character\CharacterEntity;
use App\Domain\Character\CharacterId;
use App\Domain\Character\CharacterRepositoryInterface;
use Doctrine\DBAL\Connection;

readonly class DbalCharacterRepository implements CharacterRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {}

    public function generateId(): CharacterId
    {
        return CharacterId::generate();
    }

    public function store(CharacterEntity $characterEntity): CharacterId
    {
        // TODO: Implement store() method.
    }
}