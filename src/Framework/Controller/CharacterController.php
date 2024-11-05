<?php

namespace App\Framework\Controller;

use App\Application\Character\CharacterFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/character', name: 'character.')]
class CharacterController extends AbstractController
{
    public function __construct(
        private readonly CharacterFinderInterface $characterFinder,
    )
    {
    }

    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            'character/index.html.twig',
            ['characters' => $this->characterFinder->all()]
        );
    }

}