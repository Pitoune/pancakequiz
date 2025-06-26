<?php

namespace App\BusinessLogic\UseCase\Query\ShowGameScoreQuery;

class ShowGameScoreViewModel
{
    public string $token;

    public string $name;

    public array $scores = [];

    public bool $gameOver;
}
