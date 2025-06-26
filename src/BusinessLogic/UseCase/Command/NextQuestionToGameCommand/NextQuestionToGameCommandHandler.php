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

    public function handle(NextQuestionToGameCommandRequest $request): bool
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

            return true;
        }

        foreach ($questions as $quest) {
            if ($quest->getId() > $question->getId()) {
                $game->setCurrentQuestion($quest);
                $this->gameRepository->save($game);

                return true;
            }
        }

        return false;
    }
}
