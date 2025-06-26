<?php

namespace App\BusinessLogic\Gateway\Query;

interface QuizQueryInterface
{
    public function getWithQuestionsCount(string $token): array;
}
