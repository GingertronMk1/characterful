<?php

namespace App\Domain\Character;

interface CharacterRepositoryInterface
{
    public function generateId(): CharacterId;

    public function create(CharacterEntity $characterEntity): CharacterId;
    public function update(CharacterEntity $characterEntity): CharacterId;
}