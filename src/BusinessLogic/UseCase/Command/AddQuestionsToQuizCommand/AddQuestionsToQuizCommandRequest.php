<?php

namespace App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand;

class AddQuestionsToQuizCommandRequest
{
    public string $quizToken;

    public array $questions = [];
}
