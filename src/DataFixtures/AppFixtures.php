<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\FeedSource;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
    ) {}

    public function load(ObjectManager $manager)
    {
        $feedSource = new FeedSource();
        $feedSource
            ->setName('Infor Kadry')
            ->setUrl('https://rss.infor.pl/rss/kadry_artykuly.xml');
        $manager->persist($feedSource);

        $user = new User();
        $user
            ->setUsername('user')
            ->setPassword($this->hasher->hashPassword($user, '12345'))
            ->addSource($feedSource);
        $manager->persist($user);
        
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
