<?php

namespace App\MessageHandler;

use App\Message\FeedReloadMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class FeedReloadMessageHandler implements MessageHandlerInterface
{
    public function __invoke(FeedReloadMessage $message)
    {
        // do something with your message
    }
}
