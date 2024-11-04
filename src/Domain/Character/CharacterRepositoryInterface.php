<?php

namespace App\Domain\Character;

interface CharacterRepositoryInterface
{
    public function generateId(): CharacterId;

    public function store(CharacterEntity $characterEntity): CharacterId;
}