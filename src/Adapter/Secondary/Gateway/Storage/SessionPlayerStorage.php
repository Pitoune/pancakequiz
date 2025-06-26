<?php

namespace App\Adapter\Secondary\Gateway\Storage;

use App\BusinessLogic\Gateway\Storage\PlayerStorageInterface;
use App\BusinessLogic\Model\Player;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionPlayerStorage implements PlayerStorageInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function store(Player $player): void
    {
        $session = $this->requestStack->getSession();

        $session->set('player', $player->getId());
    }
}
