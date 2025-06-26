<?php

namespace App\BusinessLogic\Gateway\Query;

interface QuizQueryInterface
{
    public function getByToken(string $token): array;
}
