<?php

namespace App\BusinessLogic\UseCase\Command\JoinGameCommand;

use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Model\Player;

class JoinGameCommandHandler
{
    private GameRepositoryInterface $gameRepository;

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(GameRepositoryInterface $gameRepository, PlayerRepositoryInterface $playerRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    public function handle(JoinGameCommandRequest $request): Player
    {
        $game = $this->gameRepository->getByToken($request->gameToken);
        $player = $game->addPlayer($request->username);
        $this->playerRepository->save($player);

        return $player;
    }
}
