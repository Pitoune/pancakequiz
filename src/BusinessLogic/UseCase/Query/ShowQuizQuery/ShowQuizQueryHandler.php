<?php

namespace App\BusinessLogic\UseCase\Query\ShowQuizQuery;

use App\BusinessLogic\Gateway\Query\QuizQueryInterface;

class ShowQuizQueryHandler
{
    private QuizQueryInterface $quizQuery;

    public function __construct(QuizQueryInterface $quizQuery)
    {
        $this->quizQuery = $quizQuery;
    }

    public function handle(string $token): ShowQuizViewModel
    {
        $results = $this->quizQuery->getWithQuestionsCount($token);
        $quiz = reset($results);

        $viewModel = new ShowQuizViewModel();
        $viewModel->token = $quiz['token'];
        $viewModel->name = $quiz['name'];
        $viewModel->questionsCount = $quiz['questionsCount'];

        return $viewModel;
    }
}
