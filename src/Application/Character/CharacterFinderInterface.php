<?php

namespace App\Application\Character;

use App\Domain\Character\CharacterId;

interface CharacterFinderInterface
{
    public function findBySlug(string $slug): CharacterModel;
    public function findById(CharacterId $id): CharacterModel;
    public function all(): array;
}