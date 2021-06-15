<?php

namespace App\Controller;

use App\Entity\FeedSource;
use App\Service\ArticleFactory;
use App\Service\ArticleLoader;
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
    public function reload(ArticleLoader $articleLoader): Response
    {
        /** @var FeedSource[] */
        $sources = $this->getUser()->getSources();
        $newCount = $articleLoader->loadNew($sources);

        if ($newCount !== null) {
            $this->addFlash(
                'success',
                "Feed has been reloaded: $newCount new articles"
            );
        } else {
            $this->addFlash(
                'danger',
                'An error occurred while reading from one or more sources. Please check if their URL is valid.'
            );
        }

        return $this->redirectToRoute('dashboard_index');
    }
}
