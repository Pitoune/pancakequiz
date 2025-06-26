<?php

namespace App\BusinessLogic\UseCase\Query\ShowGameQuery;

use App\BusinessLogic\Gateway\Query\GameQueryInterface;
use App\BusinessLogic\Gateway\Query\QuestionQueryInterface;
use App\BusinessLogic\Model\Game;

class ShowGameQueryHandler
{
    private GameQueryInterface $gameQuery;

    private QuestionQueryInterface $questionQuery;

    public function __construct(GameQueryInterface $gameQuery, QuestionQueryInterface $questionQuery)
    {
        $this->gameQuery = $gameQuery;
        $this->questionQuery = $questionQuery;
    }

    public function handle(string $token): ShowGameViewModel
    {
        $results = $this->gameQuery->getByToken($token);
        /** @var Game $game */
        $game = reset($results);

        $viewModel = new ShowGameViewModel();
        $viewModel->token = $game['token'];
        $viewModel->name = $game['name'];
        $viewModel->questionsCount = $game['questionsCount'];
        $viewModel->players = explode(',', $game['players']);

        if ($game['currentQuestion']) {
            $question = $this->questionQuery->get($game['currentQuestion']);

            $viewModel->question = [
                'question' => $question['question'],
                'answers' => $question['answers'],
            ];
        }

        return $viewModel;
    }
}
