<?php

namespace App\BusinessLogic\Gateway\Repository;

use App\BusinessLogic\Model\Game;

interface GameRepositoryInterface
{
    public function save(Game $game): void;

    public function get(int $id): ?Game;

    public function getByToken(string $token): ?Game;
}
