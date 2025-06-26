<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\CreateQuizzCommand;

use App\BusinessLogic\Gateway\Provider\StringProviderInterface;
use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\UseCase\Command\CreateQuizzCommand\CreateQuizCommandHandler;
use App\BusinessLogic\UseCase\Command\CreateQuizzCommand\CreateQuizCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Provider\DeterministicStringProvider;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use PHPUnit\Framework\TestCase;

class CreateQuizCommandHandlerTest extends TestCase
{
    private CreateQuizCommandHandler $createQuizCommandHandler;

    private QuizRepositoryInterface $quizRepository;

    private StringProviderInterface $stringProvider;

    public function testCreateQuiz(): void
    {
        $request = new CreateQuizCommandRequest();
        $request->name = 'Quiz number 1';
        $request->questionsPerParticipant = 4;
        $request->participants = 'pierre@pancake.com, lucie@pancake.com';

        $this->createQuizCommandHandler->handle($request);

        $quiz = $this->quizRepository->get(1);
        $this->assertSame($quiz->getName(), 'Quiz number 1');
        $this->assertSame($quiz->getQuestionsPerParticipant(), 4);
        $this->assertSame($quiz->getToken(), '00000000000000000000');
    }

    protected function setUp(): void
    {
        $this->quizRepository = new InMemoryQuizRepository();
        $this->stringProvider = new DeterministicStringProvider();

        $this->createQuizCommandHandler = new CreateQuizCommandHandler($this->quizRepository, $this->stringProvider);
    }
}
