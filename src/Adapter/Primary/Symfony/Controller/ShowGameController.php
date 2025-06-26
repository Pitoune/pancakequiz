<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Query\ShowGameQuery\ShowGameQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowGameController extends AbstractController
{
    #[Route('/{_locale}/game/{token}/show', name: 'game_show')]
    public function __invoke(
        ShowGameQueryHandler $useCase,
        string $token,
    ): Response {
        return $this->render('game/show.html.twig', [
            'viewModel' => $useCase->handle($token),
        ]);
    }
}
