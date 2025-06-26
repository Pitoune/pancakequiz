<?php

namespace App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand;

use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;

class AddQuestionsToQuizCommandHandler
{
    private QuizRepositoryInterface $quizRepository;

    private QuestionRepositoryInterface $questionRepository;

    public function __construct(
        QuizRepositoryInterface $quizRepository,
        QuestionRepositoryInterface $questionRepository,
    ) {
        $this->quizRepository = $quizRepository;
        $this->questionRepository = $questionRepository;
    }

    public function handle(AddQuestionsToQuizCommandRequest $request): void
    {
        $quiz = $this->quizRepository->getOneByToken($request->quizToken);

        foreach ($request->questions as $question) {
            $quest = $quiz->addQuestion(
                $question['question'],
                $question['correct_answer'],
                $question['wrong_answer_1'],
                $question['wrong_answer_2'],
                $question['wrong_answer_3'],
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
