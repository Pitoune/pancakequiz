<?php

namespace App\BusinessLogic\UseCase\Command\StartGameToQuizCommand;

use App\BusinessLogic\Gateway\Provider\StringProviderInterface;
use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\Model\Game;

class StartGameToQuizCommandHandler
{
    private QuizRepositoryInterface $quizRepository;

    private GameRepositoryInterface $gameRepository;

    private StringProviderInterface $stringProvider;

    public function __construct(
        QuizRepositoryInterface $quizRepository,
        GameRepositoryInterface $gameRepository,
        StringProviderInterface $stringProvider,
    ) {
        $this->quizRepository = $quizRepository;
        $this->gameRepository = $gameRepository;
        $this->stringProvider = $stringProvider;
    }

    public function handle(StartGameToQuizCommandRequest $request): Game
    {
        $quiz = $this->quizRepository->getOneByToken($request->quizToken);
        $game = $quiz->addGame($this->stringProvider->random(10));

        $this->gameRepository->save($game);

        return $game;
    }
}
