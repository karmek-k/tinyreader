<?php

namespace App\Service;

use Exception;
use FeedIo\Adapter\Http\Client;
use FeedIo\FeedInterface;
use FeedIo\FeedIo;
use Psr\Http\Client\ClientInterface;

class RssReader
{
    private FeedIo $feedIo;

    public function __construct(ClientInterface $http)
    {
        $httpAdapter = new Client($http);
        $this->feedIo = new FeedIo($httpAdapter);
    }

    public function read(string $url): ?FeedInterface
    {
        try {
            return $this->feedIo->read($url)->getFeed();
        } catch (Exception $e) {
            return null;
        }
    }
}