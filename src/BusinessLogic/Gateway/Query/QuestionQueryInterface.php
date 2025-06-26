<?php

namespace App\BusinessLogic\Gateway\Query;

interface QuestionQueryInterface
{
    public function get(int $id): array;
}
