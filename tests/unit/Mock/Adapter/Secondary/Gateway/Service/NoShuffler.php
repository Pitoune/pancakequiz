<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Service;

use App\BusinessLogic\Gateway\Service\ShufflerInterface;

class NoShuffler implements ShufflerInterface
{
    public function shuffle(array $array): array
    {
        return $array;
    }
}
