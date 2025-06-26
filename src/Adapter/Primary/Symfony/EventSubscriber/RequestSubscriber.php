<?php

namespace App\Adapter\Primary\Symfony\EventSubscriber;

use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Service\PlayerContext;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestSubscriber implements EventSubscriberInterface
{
    private PlayerContext $playerContext;

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerContext $playerContext, PlayerRepositoryInterface $playerRepository)
    {
        $this->playerContext = $playerContext;
        $this->playerRepository = $playerRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $session = $event->getRequest()->getSession();
        $player = $session->get('player');
        if ($player) {
            $this->playerContext->setPlayer($this->playerRepository->get($player));
        }
    }
}
