<?php

namespace App\BusinessLogic\UseCase\Command\NextQuestionToGameCommand;

use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;

class NextQuestionToGameCommandHandler
{
    private GameRepositoryInterface $gameRepository;

    private QuestionRepositoryInterface $questionRepository;

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        QuestionRepositoryInterface $questionRepository,
        PlayerRepositoryInterface $playerRepository,
    ) {
        $this->gameRepository = $gameRepository;
        $this->questionRepository = $questionRepository;
        $this->playerRepository = $playerRepository;
    }

    public function handle(NextQuestionToGameCommandRequest $request): void
    {
        $game = $this->gameRepository->getByToken($request->gameToken);
        $questions = $this->questionRepository->allByGame($game);

        $players = $this->playerRepository->allByGame($game);
        foreach ($players as $player) {
            $player->setAnswered(false);
            $this->playerRepository->save($player);
        }

        $question = $game->getCurrentQuestion();
        if (null === $question) {
            $firstQuestion = reset($questions);
            $game->setCurrentQuestion($firstQuestion);

            $this->gameRepository->save($game);

            return;
        }

        $next = false;
        foreach ($questions as $quest) {
            if ($next) {
                $game->setCurrentQuestion($quest);

                return;
            }

            if ($quest !== $question) {
                continue;
            }
            $next = true;
        }
    }
}
