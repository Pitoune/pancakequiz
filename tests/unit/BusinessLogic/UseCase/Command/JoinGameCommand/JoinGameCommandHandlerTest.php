<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\JoinGameCommand;

use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Quiz;
use App\BusinessLogic\UseCase\Command\JoinGameCommand\JoinGameCommandHandler;
use App\BusinessLogic\UseCase\Command\JoinGameCommand\JoinGameCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryGameRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryPlayerRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Storage\EmptyPlayerStorage;
use PHPUnit\Framework\TestCase;

class JoinGameCommandHandlerTest extends TestCase
{
    private JoinGameCommandHandler $joinGameCommandHandler;

    private InMemoryGameRepository $gameRepository;

    private InMemoryPlayerRepository $playerRepository;

    private EmptyPlayerStorage $emptyPlayerStorage;

    private InMemoryQuizRepository $quizRepository;

    public function testJoinGame(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $request = new JoinGameCommandRequest();
        $request->username = 'username';
        $request->gameToken = 'game-token';

        $this->joinGameCommandHandler->handle($request);
        $player = $this->playerRepository->get(1);

        $this->assertEquals('username', $player->getUsername());
        $this->assertEquals('game-token', $player->getGame()->getToken());
    }

    protected function setUp(): void
    {
        $this->gameRepository = new InMemoryGameRepository();
        $this->playerRepository = new InMemoryPlayerRepository();
        $this->emptyPlayerStorage = new EmptyPlayerStorage();
        $this->quizRepository = new InMemoryQuizRepository();

        $this->joinGameCommandHandler = new JoinGameCommandHandler(
            $this->gameRepository,
            $this->playerRepository,
            $this->emptyPlayerStorage,
        );
    }
}
