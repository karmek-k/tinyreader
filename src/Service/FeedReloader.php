<?php

namespace App\Service;

use App\Entity\User;
use App\Message\FeedReloadMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class FeedReloader
{
    public function __construct(private MessageBusInterface $bus) {}

    public function requestReload(User $user): void
    {
        $this->bus->dispatch(new FeedReloadMessage($user->getId()));
    }
}