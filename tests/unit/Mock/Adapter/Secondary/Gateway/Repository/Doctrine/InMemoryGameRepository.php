<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Model\Game;

class InMemoryGameRepository implements GameRepositoryInterface
{
    private array $games = [];

    public function save(Game $game): void
    {
        $id = $game->getId() ?? 1;

        $this->games[$id] = $game;
    }

    public function get(int $id): ?Game
    {
        return $this->games[$id] ?? null;
    }

    public function getByToken(string $token): ?Game
    {
        foreach ($this->games as $game) {
            if ($game->getToken() === $token) {
                return $game;
            }
        }

        return null;
    }
}
