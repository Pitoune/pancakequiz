<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Command\NextQuestionToGameCommand\NextQuestionToGameCommandHandler;
use App\BusinessLogic\UseCase\Command\NextQuestionToGameCommand\NextQuestionToGameCommandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NextQuestionToGameController extends AbstractController
{
    #[Route('/{_locale}/game/{token}/next-question', name: 'game_next_question')]
    public function __invoke(
        NextQuestionToGameCommandHandler $useCase,
        NextQuestionToGameCommandRequest $useCaseRequest,
        Request $request,
        string $token,
    ): RedirectResponse {
        $useCaseRequest->gameToken = $token;
        $nextQuestion = $useCase->handle($useCaseRequest);

        $route = 'game_show';
        if (!$nextQuestion) {
            $route = 'game_show_score';
        }

        return $this->redirectToRoute($route, ['token' => $token]);
    }
}
