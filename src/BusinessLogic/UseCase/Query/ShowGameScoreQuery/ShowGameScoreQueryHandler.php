<?php

namespace App\BusinessLogic\UseCase\Query\ShowGameScoreQuery;

use App\BusinessLogic\Gateway\Query\GameQueryInterface;
use App\BusinessLogic\Model\Game;

class ShowGameScoreQueryHandler
{
    private GameQueryInterface $gameQuery;

    public function __construct(GameQueryInterface $gameQuery)
    {
        $this->gameQuery = $gameQuery;
    }

    public function handle(string $token): ShowGameScoreViewModel
    {
        $results = $this->gameQuery->getByToken($token);
        /** @var Game $game */
        $game = reset($results);

        $viewModel = new ShowGameScoreViewModel();
        $viewModel->token = $game['token'];
        $viewModel->name = $game['name'];
        $viewModel->scores = $this->gameQuery->getScoresByToken($token);

        return $viewModel;
    }
}
