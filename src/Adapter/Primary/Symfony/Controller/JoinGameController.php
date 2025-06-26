<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\Adapter\Primary\Symfony\Form\Type\JoinGameType;
use App\BusinessLogic\UseCase\Command\JoinGameCommand\JoinGameCommandHandler;
use App\BusinessLogic\UseCase\Command\JoinGameCommand\JoinGameCommandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JoinGameController extends AbstractController
{
    #[Route('/{_locale}/game/{token}/join', name: 'game_join', methods: ['GET', 'POST'])]
    public function __invoke(
        JoinGameCommandHandler $useCase,
        JoinGameCommandRequest $useCaseRequest,
        Request $request,
        string $token,
    ): Response {
        $useCaseRequest->gameToken = $token;

        $form = $this->createForm(JoinGameType::class, $useCaseRequest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($useCaseRequest);

            return $this->redirectToRoute('game_show', ['token' => $token]);
        }

        return $this->render('game/join.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
