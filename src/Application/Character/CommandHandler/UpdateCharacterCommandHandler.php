<?php

namespace App\Application\Character\CommandHandler;

use App\Application\Character\Command\UpdateCharacterCommand;
use App\Domain\Character\CharacterEntity;
use App\Domain\Character\CharacterId;
use App\Domain\Character\CharacterRepositoryInterface;

class UpdateCharacterCommandHandler
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
    ) {}

    public function handle(UpdateCharacterCommand $command): CharacterId
    {
        $entity = new CharacterEntity(
            id: $command->characterId,
            name: $command->name,
            levels: $command->levels,
            armour_class: $command->armour_class,
            proficiency_bonus: $command->proficiency_bonus,
            speed: $command->speed,
            passive_perception: $command->passive_perception,
            current_hit_points: $command->current_hit_points,
            max_hit_points: $command->max_hit_points,
            temporary_hit_points: $command->temporary_hit_points,
            weapons: $command->weapons,
            armours: $command->armours,
            abilities: $command->abilities,
            skills: $command->skills,
            saving_throws: $command->saving_throws,
            hit_dice_type: $command->hit_dice_type,
            current_hit_dice: $command->current_hit_dice,
            max_hit_dice: $command->max_hit_dice,
        );

        return $this->characterRepository->update($entity);
    }
}
