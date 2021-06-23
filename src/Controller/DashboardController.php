<?php

namespace App\Controller;

use App\Entity\FeedSource;
use App\Message\FeedReloadMessage;
use App\Repository\ArticleRepository;
use App\Service\ArticleFactory;
use App\Service\ArticleLoader;
use App\Service\FeedReloader;
use App\Service\RssReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard_index')]
    public function index(ArticleRepository $articleRepo): Response
    {
        /** @var FeedSource[] */
        $sources = $this->getUser()->getSources();

        return $this->render('dashboard/index.html.twig', [
            'sources' => $sources,
            'article_repo' => $articleRepo,
        ]);
    }

    #[Route('/reload', name: 'dashboard_reload')]
    public function reload(FeedReloader $feedReloader): Response
    {
        $feedReloader->requestReload($this->getUser());

        $this->addFlash(
            'success',
            'A feed reload job has been started. '
            . 'Please wait 10-15 seconds and refresh the page.'
        );

        return $this->redirectToRoute('dashboard_index');
    }
}
