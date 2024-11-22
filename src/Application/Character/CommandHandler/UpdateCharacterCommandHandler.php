<?php

namespace App\Application\Character\CommandHandler;

use App\Application\Character\Command\UpdateCharacterCommand;
use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Application\Util\Model\Weapon;
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
            slug: $command->slug,
            species: $command->species,
            species_extra: $command->species_extra,
            levels: array_map(
                static fn (Level $level) => $level->toArray(),
                $command->levels,
            ),
            armour_class: $command->armour_class,
            proficiency_bonus: $command->proficiency_bonus,
            speed: $command->speed,
            passive_perception: $command->passive_perception,
            current_hit_points: $command->current_hit_points,
            max_hit_points: $command->max_hit_points,
            temporary_hit_points: $command->temporary_hit_points,
            weapons: array_map(
                static fn (Weapon $weapon) => $weapon->toArray(),
                $command->weapons,
            ),
            armours: $command->armours,
            abilities: array_map(
                static fn (AbilityScore $score) => $score->toArray(),
                $command->abilities,
            ),
            skills: array_map(
                static fn (SkillScore $skillScore) => $skillScore->toArray(),
                $command->skills,
            ),
            saving_throws: $command->saving_throws,
            hit_dice_type: $command->hit_dice_type,
            current_hit_dice: $command->current_hit_dice,
            max_hit_dice: $command->max_hit_dice,
        );

        return $this->characterRepository->update($entity);
    }
}
