<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;
use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Question;

class InMemoryQuestionRepository implements QuestionRepositoryInterface
{
    private array $questions = [];

    private int $count = 0;

    public function save(Question $question): void
    {
        $id = $question->getId() ?? ++$this->count;

        $this->questions[$id] = $question;
    }

    public function all(): array
    {
        return $this->questions;
    }

    public function allByGame(Game $game): array
    {
        return $this->questions;
    }
}
