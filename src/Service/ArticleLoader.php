<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ArticleLoader
{
    public function __construct(
        private RssReader $rss,
        private ArticleFactory $articleFactory,
        private EntityManagerInterface $em,
    ) {}

    /**
     * @param FeedSource[] $sources
     */
    public function loadNew(array $sources): void
    {
        foreach ($sources as $source) {
            $feed = $this->rss->read($source->getUrl());
            $rssArticles = $this->articleFactory->fromFeedAll($feed);

            $storedArticles = $source->getArticles()->toArray();

            foreach ($rssArticles as $rssArticle) {
                if (!in_array($rssArticle->getTitle(), $storedArticles)) {
                    $this->em->persist($rssArticle);
                    $source->addArticle($rssArticle);
                }
            }
        }

        $this->em->flush();
    }
}
