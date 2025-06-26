<?php

namespace App\BusinessLogic\UseCase\Command\JoinGameCommand;

use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Gateway\Storage\PlayerStorageInterface;
use App\BusinessLogic\Model\Player;

class JoinGameCommandHandler
{
    private GameRepositoryInterface $gameRepository;

    private PlayerRepositoryInterface $playerRepository;

    private PlayerStorageInterface $playerStorage;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        PlayerRepositoryInterface $playerRepository,
        PlayerStorageInterface $playerStorage,
    ) {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->playerStorage = $playerStorage;
    }

    public function handle(JoinGameCommandRequest $request): Player
    {
        $game = $this->gameRepository->getByToken($request->gameToken);
        $player = $game->addPlayer($request->username);
        $this->playerRepository->save($player);
        $this->playerStorage->store($player);

        return $player;
    }
}
