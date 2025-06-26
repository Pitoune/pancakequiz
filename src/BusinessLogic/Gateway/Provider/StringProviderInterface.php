<?php

namespace App\BusinessLogic\Gateway\Provider;

interface StringProviderInterface
{
    public function random(int $length): string;
}
