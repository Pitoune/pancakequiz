<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\RecordAnswerCommand;

use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Player;
use App\BusinessLogic\Model\Question;
use App\BusinessLogic\Model\Quiz;
use App\BusinessLogic\Service\PlayerContext;
use App\BusinessLogic\Service\ScoreCalculator;
use App\BusinessLogic\UseCase\Command\RecordAnswerCommand\RecordAnswerCommandHandler;
use App\BusinessLogic\UseCase\Command\RecordAnswerCommand\RecordAnswerCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryGameRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryPlayerRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuestionRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use PHPUnit\Framework\TestCase;

class RecordAnswerCommandHandlerTest extends TestCase
{
    private RecordAnswerCommandHandler $recordAnswerCommandHandler;

    private PlayerContext $playerContext;

    private InMemoryPlayerRepository $playerRepository;

    private InMemoryGameRepository $gameRepository;

    private ScoreCalculator $scoreCalculator;

    private InMemoryQuizRepository $quizRepository;

    private InMemoryQuestionRepository $questionRepository;

    public function testRecordAnswerCorrect(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'B', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $game->setCurrentQuestion($question);
        $milliseconds = floor(microtime(true) * 1000);
        $game->setLastQuestionTime($milliseconds - 2000);
        $this->gameRepository->save($game);

        $player = new Player(1, $game, 'Pitoune');
        $this->playerRepository->save($player);

        $this->playerContext->setPlayer($player);

        $request = new RecordAnswerCommandRequest();
        $request->answer = 'B';

        $this->recordAnswerCommandHandler->handle($request);

        $player = $this->playerRepository->get(1);
        $this->assertTrue($player->hasAnswered());
        $this->assertSame(1000, $player->getScore());
    }

    public function testRecordAnswerCorrectWithDelay(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'B', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $game->setCurrentQuestion($question);
        $milliseconds = floor(microtime(true) * 1000);
        $game->setLastQuestionTime($milliseconds - 8765);
        $this->gameRepository->save($game);

        $player = new Player(1, $game, 'Pitoune');
        $this->playerRepository->save($player);

        $this->playerContext->setPlayer($player);

        $request = new RecordAnswerCommandRequest();
        $request->answer = 'B';

        $this->recordAnswerCommandHandler->handle($request);

        $player = $this->playerRepository->get(1);
        $this->assertTrue($player->hasAnswered());
        $this->assertSame(808, $player->getScore());
    }

    public function testRecordAnswerWrong(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'B', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $game->setCurrentQuestion($question);
        $this->gameRepository->save($game);

        $player = new Player(1, $game, 'Pitoune');
        $this->playerRepository->save($player);

        $this->playerContext->setPlayer($player);

        $request = new RecordAnswerCommandRequest();
        $request->answer = 'A';

        $this->recordAnswerCommandHandler->handle($request);

        $player = $this->playerRepository->get(1);
        $this->assertTrue($player->hasAnswered());
        $this->assertSame(0, $player->getScore());
    }

    public function testRecordAnswerCorrectDoesNotWorkAfterWrongAnswer(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $game = new Game(1, 'game-token', $quiz);
        $this->gameRepository->save($game);

        $question = new Question(1, $quiz, 'Why ?', 'B', ['A' => 'Because', 'B' => 'Wrong 1', 'C' => 'Wrong 2', 'D' => 'Wrong 3']);
        $this->questionRepository->save($question);

        $game->setCurrentQuestion($question);
        $this->gameRepository->save($game);

        $player = new Player(1, $game, 'Pitoune');
        $player->setAnswered(true);
        $this->playerRepository->save($player);

        $this->playerContext->setPlayer($player);

        $request = new RecordAnswerCommandRequest();
        $request->answer = 'B';

        $this->recordAnswerCommandHandler->handle($request);

        $player = $this->playerRepository->get(1);
        $this->assertTrue($player->hasAnswered());
        $this->assertSame(0, $player->getScore());
    }

    protected function setUp(): void
    {
        $this->playerContext = new PlayerContext();
        $this->playerRepository = new InMemoryPlayerRepository();
        $this->gameRepository = new InMemoryGameRepository();
        $this->scoreCalculator = new ScoreCalculator();
        $this->quizRepository = new InMemoryQuizRepository();
        $this->questionRepository = new InMemoryQuestionRepository();

        $this->recordAnswerCommandHandler = new RecordAnswerCommandHandler(
            $this->playerContext,
            $this->playerRepository,
            $this->gameRepository,
            $this->scoreCalculator,
        );
    }
}
