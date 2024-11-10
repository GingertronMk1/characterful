<?php

namespace App\Domain\Character;

use App\Domain\Common\AbstractMappedEntity;
use App\Domain\Util\HelperInterface;

readonly class CharacterEntity extends AbstractMappedEntity
{
    /**
     * @param array<array<string, int|string>> $levels
     * @param string[] $weapons
     * @param string[] $armours
     * @param array<array<string, int|string>> $abilities
     * @param array<array<string, int|string>> $skills
     * @param string[] $armour_class
     * @param string[] $saving_throws
     */
    public function __construct(
        public CharacterId $id,
        public string $name,
        public array $levels,
        public array $armour_class,
        public int $proficiency_bonus,
        public int $speed,
        public int $passive_perception,
        public int $current_hit_points,
        public int $max_hit_points,
        public int $temporary_hit_points,
        public array $weapons,
        public array $armours,
        public array $abilities,
        public array $skills,
        public array $saving_throws,
        public int $hit_dice_type,
        public int $current_hit_dice,
        public int $max_hit_dice,
    ) {}

    /**
     * @throws \Exception
     */
    public function getMappedData(array $externalServices = []): array
    {
        /** @var HelperInterface $helpers */
        $helpers = $this->getServiceIfExists(HelperInterface::class, $externalServices);

        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'levels' => $helpers->jsonEncode($this->levels),
            'armour_class' => $helpers->jsonEncode($this->armour_class),
            'proficiency_bonus' => $this->proficiency_bonus,
            'speed' => $this->speed,
            'passive_perception' => $this->passive_perception,
            'current_hit_points' => $this->current_hit_points,
            'max_hit_points' => $this->max_hit_points,
            'temporary_hit_points' => $this->temporary_hit_points,
            'weapons' => $helpers->jsonEncode($this->weapons),
            'armours' => $helpers->jsonEncode($this->armours),
            'abilities' => $helpers->jsonEncode($this->abilities),
            'skills' => $helpers->jsonEncode($this->skills),
            'saving_throws' => $helpers->jsonEncode($this->saving_throws),
            'hit_dice_type' => $this->hit_dice_type,
            'current_hit_dice' => $this->current_hit_dice,
            'max_hit_dice' => $this->max_hit_dice,
        ];
    }
}
