<?php

namespace App\Service;

use App\Message\FeedReloadMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FeedReloader
{
    public function __construct(private MessageBusInterface $bus) {}

    public function requestReload(UserInterface $user): void
    {
        $this->bus->dispatch(new FeedReloadMessage($user->getId()));
    }
}