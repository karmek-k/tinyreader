<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        if ($this->getUser()) {
            // TODO: redirect to dashboard
            // return $this->redirectToRoute('');
        }

        return $this->redirectToRoute('app_login');
    }
}
