<?php

namespace App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand;

use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\Gateway\Service\ShufflerInterface;

class AddQuestionsToQuizCommandHandler
{
    private QuizRepositoryInterface $quizRepository;

    private QuestionRepositoryInterface $questionRepository;

    private ShufflerInterface $shuffler;

    public function __construct(
        QuizRepositoryInterface $quizRepository,
        QuestionRepositoryInterface $questionRepository,
        ShufflerInterface $shuffler,
    ) {
        $this->quizRepository = $quizRepository;
        $this->questionRepository = $questionRepository;
        $this->shuffler = $shuffler;
    }

    public function handle(AddQuestionsToQuizCommandRequest $request): void
    {
        $quiz = $this->quizRepository->getOneByToken($request->quizToken);

        foreach ($request->questions as $question) {
            $answers = [
                $question['correct_answer'],
                $question['wrong_answer_1'],
                $question['wrong_answer_2'],
                $question['wrong_answer_3'],
            ];
            $correctAnswer = null;
            $indexes = ['A', 'B', 'C', 'D'];
            $indexedAnswers = [];

            $shuffled = $this->shuffler->shuffle($answers);
            foreach ($shuffled as $answer) {
                $idx = array_splice($indexes, 0, 1);
                $indexedAnswers[$idx[0]] = $answer;
                if ($question['correct_answer'] === $answer) {
                    $correctAnswer = $idx[0];
                }
            }

            $quest = $quiz->addQuestion(
                $question['question'],
                $correctAnswer,
                $indexedAnswers,
            );
            $this->questionRepository->save($quest);
        }
    }

    public function prepareRequest(string $quizToken): AddQuestionsToQuizCommandRequest
    {
        $quiz = $this->quizRepository->getOneByToken($quizToken);

        $request = new AddQuestionsToQuizCommandRequest();
        $request->quizToken = $quiz->getToken();
        $request->questions = [];
        for ($i = 1; $i <= $quiz->getQuestionsPerParticipant(); ++$i) {
            $request->questions[] = [
                'question' => '',
                'correct_answer' => '',
                'wrong_answer_1' => '',
                'wrong_answer_2' => '',
                'wrong_answer_3' => '',
            ];
        }

        return $request;
    }
}
