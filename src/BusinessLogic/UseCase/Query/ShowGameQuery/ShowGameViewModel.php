<?php

namespace App\BusinessLogic\UseCase\Query\ShowGameQuery;

class ShowGameViewModel
{
    public string $token;

    public string $name;

    public int $questionsCount;

    public array $players;
}
