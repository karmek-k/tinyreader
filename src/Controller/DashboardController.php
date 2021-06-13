<?php

namespace App\Controller;

use App\Entity\FeedSource;
use App\Service\ArticleFactory;
use App\Service\RssReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard_index')]
    public function index(): Response
    {
        /** @var FeedSource[] */
        $sources = $this->getUser()->getSources();

        return $this->render('dashboard/index.html.twig', [
            'sources' => $sources,
        ]);
    }

    #[Route('/reload', name: 'dashboard_reload')]
    public function reload(ArticleFactory $articleFactory, RssReader $rss): Response
    {
        /** @var FeedSource[] */
        $sources = $this->getUser()->getSources();

        $em = $this->getDoctrine()->getManager();

        // TODO: this is horribly bad, improve this & move to an external service
        foreach ($sources as $source) {
            $feed = $rss->read($source->getUrl());
            $rssArticles = $articleFactory->fromFeedAll($feed);

            $storedArticles = $source->getArticles()->toArray();

            foreach ($rssArticles as $rssArticle) {
                if (!in_array($rssArticle->getTitle(), $storedArticles)) {
                    $em->persist($rssArticle);
                    $source->addArticle($rssArticle);
                }   
            }
        }

        $em->flush();

        $this->addFlash('success', 'Feed has been reloaded');

        return $this->redirectToRoute('dashboard_index');
    }
}
