<?php

namespace App\Infrastructure\Character;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\CharacterModel;
use App\Domain\Character\CharacterId;
use Doctrine\DBAL\Connection;

readonly class DbalCharacterFinder implements CharacterFinderInterface
{
    private const TABLE_NAME = 'characters';
    public function __construct(
        private Connection $connection
    ) {}

    public function findBySlug(string $slug): CharacterModel
    {
        // TODO: Implement findBySlug() method.
    }

    public function findById(CharacterId $id): CharacterModel
    {
        // TODO: Implement findById() method.
    }

    public function all(): array
    {
        // TODO: Implement all() method.
    }
}