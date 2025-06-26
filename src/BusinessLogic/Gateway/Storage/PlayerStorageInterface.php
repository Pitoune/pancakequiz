<?php

namespace App\BusinessLogic\Gateway\Storage;

use App\BusinessLogic\Model\Player;

interface PlayerStorageInterface
{
    public function store(Player $player): void;
}
