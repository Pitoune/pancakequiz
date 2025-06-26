<?php

namespace App\BusinessLogic\Gateway\Repository;

use App\BusinessLogic\Model\Question;

interface QuestionRepositoryInterface
{
    public function save(Question $question): void;

    public function all(): array;
}
