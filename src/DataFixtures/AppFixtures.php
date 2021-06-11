<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\FeedSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $feedSource = new FeedSource();
        $feedSource
            ->setName('Infor Kadry')
            ->setUrl('https://rss.infor.pl/rss/kadry_artykuly.xml');
        $manager->persist($feedSource);
        
        $article = new Article();
        $article
            ->setTitle('Składka zdrowotna 2021')
            ->setUrl('https://kadry.infor.pl/ubezpieczenia-spoleczne/ubezpieczenia-zdrowotne/5275077,Skladka-zdrowotna-2021-dzialalnosc-gospodarcza.html')
            ->setExcerpt('Składka zdrowotna w 2021 r. a działalność gospodarcza - ile wynosi wysokość składki zdrowotnej? Jak Nowy Ład wpłynie na wysokość składki zdrowotnej?')
            ->setSource($feedSource);
        $manager->persist($article);

        $manager->flush();
    }
}
