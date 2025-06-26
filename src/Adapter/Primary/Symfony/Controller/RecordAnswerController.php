<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\BusinessLogic\UseCase\Command\RecordAnswerCommand\RecordAnswerCommandHandler;
use App\BusinessLogic\UseCase\Command\RecordAnswerCommand\RecordAnswerCommandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class RecordAnswerController extends AbstractController
{
    #[Route('/{_locale}/game/record-answer/{answer}', name: 'game_record_answer')]
    public function __invoke(
        RecordAnswerCommandHandler $useCase,
        RecordAnswerCommandRequest $useCaseRequest,
        string $answer,
    ): RedirectResponse {
        $useCaseRequest->answer = $answer;
        $useCase->handle($useCaseRequest);

        return $this->redirectToRoute('game_answer');
    }
}
