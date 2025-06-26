<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Command\StartGameToQuizCommand\StartGameToQuizCommandHandler;
use App\BusinessLogic\UseCase\Command\StartGameToQuizCommand\StartGameToQuizCommandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class StartGameToQuizController extends AbstractController
{
    #[Route('/{_locale}/quiz/{token}/start-game', name: 'quiz_start_game')]
    public function __invoke(
        StartGameToQuizCommandHandler $useCase,
        StartGameToQuizCommandRequest $useCaseRequest,
        Request $request,
        string $token,
    ): RedirectResponse {
        $useCaseRequest->quizToken = $token;
        $useCase->handle($useCaseRequest);

        return $this->redirectToRoute('quiz_show', ['token' => $token]);
    }
}
