<?php

namespace App\Service;

use FeedIo\FeedInterface;
use FeedIo\FeedIo;

class RssReader
{
    private FeedIo $feedIo;

    public function __construct()
    {
        $this->feedIo = \FeedIo\Factory::create()->getFeedIo();
    }

    public function read(string $url): FeedInterface
    {
        return $this->feedIo->read($url)->getFeed();
    }
}