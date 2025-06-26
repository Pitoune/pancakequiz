<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Storage;

use App\BusinessLogic\Gateway\Storage\PlayerStorageInterface;
use App\BusinessLogic\Model\Player;

class EmptyPlayerStorage implements PlayerStorageInterface
{
    public function store(Player $player): void
    {
    }
}
