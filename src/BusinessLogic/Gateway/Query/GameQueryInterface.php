<?php

namespace App\BusinessLogic\Gateway\Query;

interface GameQueryInterface
{
    public function getByToken(string $token): array;

    public function getScoresByToken(string $token): array;
}
