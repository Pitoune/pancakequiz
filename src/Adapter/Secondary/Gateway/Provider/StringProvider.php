<?php

namespace App\Adapter\Secondary\Gateway\Provider;

use App\BusinessLogic\Gateway\Provider\StringProviderInterface;

class StringProvider implements StringProviderInterface
{
    public function random(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
}
