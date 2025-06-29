<?php

namespace App\Tests\unit\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand;

use App\BusinessLogic\Model\Quiz;
use App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand\AddQuestionsToQuizCommandHandler;
use App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand\AddQuestionsToQuizCommandRequest;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuestionRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine\InMemoryQuizRepository;
use App\Tests\unit\Mock\Adapter\Secondary\Gateway\Service\NoShuffler;
use PHPUnit\Framework\TestCase;

class AddQuestionsToQuizCommandHandlerTest extends TestCase
{
    private AddQuestionsToQuizCommandHandler $addQuestionsToQuizCommandHandler;

    private InMemoryQuizRepository $quizRepository;

    private InMemoryQuestionRepository $questionRepository;

    private NoShuffler $shuffler;

    public function testAddOneQuestionToQuiz(): void
    {
        $quiz = new Quiz(1, 'quiz-token', 'Quiz 1', 1);
        $this->quizRepository->save($quiz);

        $request = new AddQuestionsToQuizCommandRequest();
        $request->quizToken = 'quiz-token';
        $request->questions = [
            [
                'question' => 'Question 1',
                'correct_answer' => 'correct answer !',
                'wrong_answer_1' => 'wrong answer 1',
                'wrong_answer_2' => 'wrong answer 2',
                'wrong_answer_3' => 'wrong answer 3',
            ],
        ];

        $this->addQuestionsToQuizCommandHandler->handle($request);
        $questions = $this->questionRepository->all();

        $this->assertCount(1, $questions);
        $question = reset($questions);
        $this->assertEquals('quiz-token', $question->getQuiz()->getToken());
        $this->assertEquals('Question 1', $question->getQuestion());
        $this->assertEquals('A', $question->getCorrectAnswer());
        $this->assertEquals([
            'A' => 'correct answer !',
            'B' => 'wrong answer 1',
            'C' => 'wrong answer 2',
            'D' => 'wrong answer 3',
        ], $question->getAnswers());
    }

    protected function setUp(): void
    {
        $this->quizRepository = new InMemoryQuizRepository();
        $this->questionRepository = new InMemoryQuestionRepository();
        $this->shuffler = new NoShuffler();

        $this->addQuestionsToQuizCommandHandler = new AddQuestionsToQuizCommandHandler(
            $this->quizRepository,
            $this->questionRepository,
            $this->shuffler,
        );
    }
}
