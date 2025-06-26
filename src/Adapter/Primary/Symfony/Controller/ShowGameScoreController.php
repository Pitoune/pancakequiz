<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Query\ShowGameScoreQuery\ShowGameScoreQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowGameScoreController extends AbstractController
{
    #[Route('/{_locale}/game/{token}/show-score', name: 'game_show_score')]
    public function __invoke(
        ShowGameScoreQueryHandler $useCase,
        string $token,
    ): Response {
        return $this->render('game/show-score.html.twig', [
            'viewModel' => $useCase->handle($token),
        ]);
    }
}
