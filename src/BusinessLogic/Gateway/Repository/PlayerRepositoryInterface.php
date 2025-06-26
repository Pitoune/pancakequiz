<?php

namespace App\BusinessLogic\Gateway\Repository;

use App\BusinessLogic\Model\Player;

interface PlayerRepositoryInterface
{
    public function save(Player $player): void;

    public function get(int $id): ?Player;
}
