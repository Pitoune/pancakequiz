<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\StartGameToQuizCommand;

use App\BusinessLogic\Model\Quiz;
use App\BusinessLogic\UseCase\Command\StartGameToQuizCommand\StartGameToQuizCommandHandler;
use App\BusinessLogic\UseCase\Command\StartGameToQuizCommand\StartGameToQuizCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Provider\DeterministicStringProvider;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryGameRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use PHPUnit\Framework\TestCase;

class StartGameToQuizCommandHandlerTest extends TestCase
{
    private StartGameToQuizCommandHandler $startGameToQuizCommandHandler;

    private InMemoryQuizRepository $quizRepository;

    private InMemoryGameRepository $gameRepository;

    private DeterministicStringProvider $stringProvider;

    public function testStartGame(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $request = new StartGameToQuizCommandRequest();
        $request->quizToken = 'quiz-token';

        $this->startGameToQuizCommandHandler->handle($request);
        $game = $this->gameRepository->get(1);

        $this->assertSame('quiz-token', $game->getQuiz()->getToken());
        $this->assertSame('0000000000', $game->getToken());
    }

    protected function setUp(): void
    {
        $this->quizRepository = new InMemoryQuizRepository();
        $this->gameRepository = new InMemoryGameRepository();
        $this->stringProvider = new DeterministicStringProvider();

        $this->startGameToQuizCommandHandler = new StartGameToQuizCommandHandler(
            $this->quizRepository,
            $this->gameRepository,
            $this->stringProvider,
        );
    }
}
