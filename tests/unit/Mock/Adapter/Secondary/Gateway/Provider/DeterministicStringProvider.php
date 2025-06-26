<?php

namespace App\Tests\unit\Mock\Adapter\Secondary\Gateway\Provider;

use App\BusinessLogic\Gateway\Provider\StringProviderInterface;

class DeterministicStringProvider implements StringProviderInterface
{
    public function random(int $length): string
    {
        return substr('00000000000000000000000000000000000000000000000000000000000000000000000000', 0, $length);
    }
}
