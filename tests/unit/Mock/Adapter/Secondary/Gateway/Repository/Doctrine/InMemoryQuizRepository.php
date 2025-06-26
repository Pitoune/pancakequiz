<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\Model\Quiz;

class InMemoryQuizRepository implements QuizRepositoryInterface
{
    private array $quiz = [];

    public function save(Quiz $quiz): void
    {
        $id = $quiz->getId() ?? 1;

        $this->quiz[$id] = $quiz;
    }

    public function get(int $id): ?Quiz
    {
        return $this->quiz[$id] ?? null;
    }

    public function getOneByToken(string $token): ?Quiz
    {
        foreach ($this->quiz as $quiz) {
            if ($quiz->getToken() === $token) {
                return $quiz;
            }
        }

        return null;
    }
}
