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

    public function loadNew(mixed $sources): int
    {
        $newCount = 0;

        foreach ($sources as $source) {
            $feed = $this->rss?->read($source->getUrl());

            if ($feed === null) {
                return 0;
            }

            $rssArticles = $this->articleFactory->fromFeedAll($feed);

            $storedArticles = $source->getArticles()->toArray();

            foreach ($rssArticles as $rssArticle) {
                // only persist new articles
                if (!in_array($rssArticle->getTitle(), $storedArticles)) {
                    $this->em->persist($rssArticle);
                    $source->addArticle($rssArticle);

                    ++$newCount;
                }
            }
        }

        $this->em->flush();

        return $newCount;
    }
}
