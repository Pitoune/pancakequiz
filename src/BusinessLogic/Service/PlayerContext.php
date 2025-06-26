<?php

namespace App\BusinessLogic\Service;

use App\BusinessLogic\Model\Player;

class PlayerContext
{
    private ?Player $player = null;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player = null): void
    {
        $this->player = $player;
    }
}
