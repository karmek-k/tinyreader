<?php

namespace App\Controller;

use App\Entity\FeedSource;
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
}
