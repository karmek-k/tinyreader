<?php

namespace App\Controller;

use App\Entity\FeedSource;
use App\Form\FeedSourceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/feed-source')]
class FeedSourceController extends AbstractController
{
    #[Route('/', name: 'feed_source_index', methods: ['GET'])]
    public function index(): Response
    {
        $sources = $this->getUser()->getSources();

        return $this->render('feed_source/index.html.twig', [
            'feed_sources' => $sources
        ]);
    }

    #[Route('/new', name: 'feed_source_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $feedSource = new FeedSource();
        $form = $this->createForm(FeedSourceType::class, $feedSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedSource);
            $entityManager->flush();

            return $this->redirectToRoute('feed_source_index');
        }

        return $this->render('feed_source/new.html.twig', [
            'feed_source' => $feedSource,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'feed_source_show', methods: ['GET'])]
    public function show(FeedSource $feedSource): Response
    {
        return $this->render('feed_source/show.html.twig', [
            'feed_source' => $feedSource,
        ]);
    }

    #[Route('/{id}/edit', name: 'feed_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FeedSource $feedSource): Response
    {
        $form = $this->createForm(FeedSourceType::class, $feedSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feed_source_index');
        }

        return $this->render('feed_source/edit.html.twig', [
            'feed_source' => $feedSource,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'feed_source_delete', methods: ['POST'])]
    public function delete(Request $request, FeedSource $feedSource): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feedSource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($feedSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('feed_source_index');
    }
}
