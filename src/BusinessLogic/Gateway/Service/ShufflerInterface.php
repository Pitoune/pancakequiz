<?php

namespace App\BusinessLogic\Gateway\Service;

interface ShufflerInterface
{
    public function shuffle(array $array): array;
}
