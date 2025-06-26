<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Player;

class InMemoryPlayerRepository implements PlayerRepositoryInterface
{
    private array $players = [];

    public function save(Player $player): void
    {
        $id = $player->getId() ?? 1;

        $this->players[$id] = $player;
    }

    public function get(int $id): ?Player
    {
        return $this->players[$id] ?? null;
    }

    public function allByGame(Game $game): array
    {
        return $this->players;
    }
}
