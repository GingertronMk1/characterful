<?php

namespace App\Framework\Controller;

use App\Application\Character\CharacterFinderInterface;
use App\Application\Character\Command\CreateCharacterCommand;
use App\Application\Character\Command\UpdateCharacterCommand;
use App\Application\Character\CommandHandler\CreateCharacterCommandHandler;
use App\Application\Character\CommandHandler\UpdateCharacterCommandHandler;
use App\Framework\Form\CreateCharacterFormType;
use App\Framework\Form\UpdateCharacterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path: '/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        CreateCharacterCommandHandler $handler
    ): Response
    {
        $command = new CreateCharacterCommand();
        $form = $this->createForm(CreateCharacterFormType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('character.index');
            } catch (\Throwable $e) {
                throw new \Exception('Error creating character', previous: $e);
            }
        }

        return $this->render(
            'character/create.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/update/{slug}', name: 'update', methods: ['GET', 'POST'])]
    public function update(
        Request $request,
        string $slug,
        UpdateCharacterCommandHandler $handler,
    ): Response
    {
        $character = $this->characterFinder->findBySlug($slug);
        $command = UpdateCharacterCommand::fromModel($character);
        $form = $this->createForm( UpdateCharacterFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('character.index');
            } catch (\Throwable $e) {
                throw new \Exception('Error creating character', previous: $e);
            }
        }

        return $this->render(
            'character/update.html.twig',
            [
                'form' => $form
            ]
        );
    }

}