<?php

namespace App\BusinessLogic\Gateway\Repository;

use App\BusinessLogic\Model\Quiz;

interface QuizRepositoryInterface
{
    public function save(Quiz $quiz): void;

    public function get(int $id): ?Quiz;

    public function getOneByToken(string $token): ?Quiz;
}
