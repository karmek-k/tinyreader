<?php

namespace App\Message;

use App\Entity\FeedSource;

final class FeedReloadMessage
{
    public function __construct(private int $userId) {}

    public function getUserId(): int
    {
        return $this->userId;
    }
}
