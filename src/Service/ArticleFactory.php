<?php

namespace App\Service;

use App\Entity\Article;
use FeedIo\Feed\Item;
use FeedIo\FeedInterface;

class ArticleFactory
{
    private function createArticle(Item $rssArticle, bool $stripTags = true): Article
    {
        /** @var string */
        $excerpt = $rssArticle->getContent();

        // remove any HTML tags
        if ($stripTags) {
            $excerpt = strip_tags($excerpt);
        }

        // replace all newlines with spaces
        /** @var string */
        $excerpt = preg_replace(
            '/\n+/',
            ' ',
            $excerpt,
        );
        $excerpt = trim($excerpt);

        $article = new Article();
        $article
            ->setTitle($rssArticle->getTitle())
            ->setExcerpt($excerpt)
            ->setLastModified($rssArticle->getLastModified())
            ->setUrl($rssArticle->getLink());
        
        return $article;
    }

    /**
     * @return Article[]
     */
    public function fromFeedAll(FeedInterface $feed, bool $stripTags = true): array
    {
        $articles = [];

        foreach ($feed as $rssArticle) {
            $articles[] = $this->createArticle($rssArticle, $stripTags);
        }

        return $articles;
    }
}