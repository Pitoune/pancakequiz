<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\Service\PlayerContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnswerPanelController extends AbstractController
{
    #[Route('/{_locale}/game/answer', name: 'game_answer')]
    public function __invoke(PlayerContext $playerContext): Response
    {
        $player = $playerContext->getPlayer();

        return $this->render('game/answer.html.twig', [
            'username' => $player->getUsername(),
        ]);
    }
}
