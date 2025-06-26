<?php

namespace App\BusinessLogic\UseCase\Query\ShowGameQuery;

use App\BusinessLogic\Gateway\Query\GameQueryInterface;

class ShowGameQueryHandler
{
    private GameQueryInterface $gameQuery;

    public function __construct(GameQueryInterface $gameQuery)
    {
        $this->gameQuery = $gameQuery;
    }

    public function handle(string $token): ShowGameViewModel
    {
        $results = $this->gameQuery->getByToken($token);
        $game = reset($results);

        $viewModel = new ShowGameViewModel();
        $viewModel->token = $game['token'];
        $viewModel->name = $game['name'];
        $viewModel->questionsCount = $game['questionsCount'];
        $viewModel->players = explode(',', $game['players']);

        return $viewModel;
    }
}
