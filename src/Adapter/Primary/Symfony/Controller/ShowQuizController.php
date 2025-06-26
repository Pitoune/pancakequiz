<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Query\ShowQuizQuery\ShowQuizQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowQuizController extends AbstractController
{
    #[Route('/{_locale}/quiz/{token}/show', name: 'quiz_show')]
    public function __invoke(
        ShowQuizQueryHandler $useCase,
        string $token,
    ): Response {
        return $this->render('quiz/show.html.twig', [
            'viewModel' => $useCase->handle($token),
        ]);
    }
}
