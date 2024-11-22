<?php

namespace App\Application\Character\CommandHandler;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\CharacterModel;
use App\Application\Character\Command\CreateCharacterCommand;
use App\Application\Util\Model\AbilityScore;
use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Application\Util\Model\Weapon;
use App\Domain\Character\CharacterEntity;
use App\Domain\Character\CharacterId;
use App\Domain\Character\CharacterRepositoryInterface;
use App\Domain\Util\HelperInterface;

readonly class CreateCharacterCommandHandler
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterFinderInterface $characterFinder,
        private HelperInterface $helpers,
    ) {}

    public function handle(CreateCharacterCommand $command): CharacterId
    {
        $initialSlug = $this->helpers->slug($command->name);
        $firstCheck = $this->checkSlug($initialSlug);
        if ($firstCheck instanceof CharacterModel) {
            $int = 1;
            do {
                $slug = "{$initialSlug}-{$int}";
                ++$int;
            } while (null !== $this->checkSlug($slug));
        } else {
            $slug = $initialSlug;
        }
        $id = $this->characterRepository->generateId();
        $entity = new CharacterEntity(
            id: $id,
            name: $command->name,
            slug: $slug,
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
                $command->weapons
            ),
            armours: $command->armours,
            abilities: array_map(
                static fn (AbilityScore $score) => $score->toArray(),
                $command->abilities,
            ),
            skills: array_map(
                static fn (SkillScore $score) => $score->toArray(),
                $command->skills,
            ),
            saving_throws: $command->saving_throws,
            hit_dice_type: $command->hit_dice_type,
            current_hit_dice: $command->current_hit_dice,
            max_hit_dice: $command->max_hit_dice,
        );

        return $this->characterRepository->create($entity);
    }

    private function checkSlug(string $slug): ?CharacterModel
    {
        try {
            return $this->characterFinder->findBySlug($slug);
        } catch (\Throwable) {
            return null;
        }
    }
}
