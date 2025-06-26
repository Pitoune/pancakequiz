<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\NextQuestionToGameCommand;

use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Player;
use App\BusinessLogic\Model\Question;
use App\BusinessLogic\Model\Quiz;
use App\BusinessLogic\UseCase\Command\NextQuestionToGameCommand\NextQuestionToGameCommandHandler;
use App\BusinessLogic\UseCase\Command\NextQuestionToGameCommand\NextQuestionToGameCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryGameRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryPlayerRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuestionRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use PHPUnit\Framework\TestCase;

class NextQuestionToGameCommandHandlerTest extends TestCase
{
    private NextQuestionToGameCommandHandler $nextQuestionToGameCommandHandler;

    private InMemoryGameRepository $gameRepository;

    private InMemoryQuizRepository $quizRepository;

    private InMemoryQuestionRepository $questionRepository;

    private InMemoryPlayerRepository $playerRepository;

    public function testNextQuestionWhenNoCurrentQuestion(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'A', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $player = new Player(1, $game, 'Pierre');
        $player->setAnswered(true);
        $this->playerRepository->save($player);

        $request = new NextQuestionToGameCommandRequest();
        $request->gameToken = 'game-token';

        $this->nextQuestionToGameCommandHandler->handle($request);

        $this->assertSame($question, $game->getCurrentQuestion());
        $this->assertFalse($player->hasAnswered());
    }

    public function testNextQuestionWhenHasCurrentQuestion(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'A', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $question2 = new Question(2, $quiz, 'Why ?', 'A', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question2);

        $question3 = new Question(3, $quiz, 'Why ?', 'A', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question3);

        $game->setCurrentQuestion($question2);
        $this->gameRepository->save($game);

        $request = new NextQuestionToGameCommandRequest();
        $request->gameToken = 'game-token';

        $this->nextQuestionToGameCommandHandler->handle($request);

        $this->assertSame($question3, $game->getCurrentQuestion());
    }

    protected function setUp(): void
    {
        $this->gameRepository = new InMemoryGameRepository();
        $this->quizRepository = new InMemoryQuizRepository();
        $this->questionRepository = new InMemoryQuestionRepository();
        $this->playerRepository = new InMemoryPlayerRepository();

        $this->nextQuestionToGameCommandHandler = new NextQuestionToGameCommandHandler(
            $this->gameRepository,
            $this->questionRepository,
            $this->playerRepository,
        );
    }
}
