<?php

namespace App\MessageHandler;

use App\Message\FeedReloadMessage;
use App\Repository\UserRepository;
use App\Service\ArticleLoader;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class FeedReloadMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ArticleLoader $loader,
        private UserRepository $userRepo,
    ) {}

    public function __invoke(FeedReloadMessage $message): void
    {
        $user = $this->userRepo->find($message->getUserId());
        if ($user === null) {
            return;
        }

        $this->loader->loadNew($user->getSources());
    }
}
