<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;
use App\BusinessLogic\Model\Question;

class InMemoryQuestionRepository implements QuestionRepositoryInterface
{
    private array $questions = [];

    public function save(Question $question): void
    {
        $id = $question->getId() ?? 1;

        $this->questions[$id] = $question;
    }

    public function all(): array
    {
        return $this->questions;
    }
}
