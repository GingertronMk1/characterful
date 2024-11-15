<?php

namespace App\Framework\Controller;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Enum\AbilityEnum;
use App\Application\Enum\SkillEnum;
use App\Domain\Character\CharacterId;
use App\Domain\Util\HelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'api', name: 'api.', format: 'json')]
class ApiController extends AbstractController
{
    public function __construct(
        private readonly CharacterFinderInterface $characterFinder,
        private readonly HelperInterface $helper,
    ) {}

    #[Route(path: '/get-ability-score/{characterId}/{ability}', name: 'get-ability-score', methods: ['GET'])]
    public function getAbilityScore(
        string $characterId,
        string $ability
    ): Response {
        $character = $this->characterFinder->findById(CharacterId::fromString($characterId));
        $abilityEnum = AbilityEnum::from($ability);

        return $this->json($this->helper->roll(20) + $character->getAbilityScore($abilityEnum)->getModifier());
    }

    #[Route(path: '/get-skill-score/{characterId}/{skill}', name: 'get-skill-score', methods: ['GET'])]
    public function getSkillScore(
        string $characterId,
        string $skill
    ): Response {
        $character = $this->characterFinder->findById(CharacterId::fromString($characterId));
        $skillEnum = SkillEnum::from($skill);

        return $this->json($this->helper->roll(20) + $character->getSkillModifier($skillEnum));
    }
}
