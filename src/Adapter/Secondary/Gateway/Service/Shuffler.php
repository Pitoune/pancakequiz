<?php

namespace App\Adapter\Secondary\Gateway\Service;

use App\BusinessLogic\Gateway\Service\ShufflerInterface;

class Shuffler implements ShufflerInterface
{
    public function shuffle(array $array): array
    {
        shuffle($array);

        return $array;
    }
}
