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
    private function userHasSource(FeedSource $source): bool
    {
        return $this->getUser()->getSources()->contains($source);
    }

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
            $this->getUser()->addSource($feedSource);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedSource);
            $entityManager->flush();

            $this->addFlash('success', 'Source was added successfully');

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
        if (!$this->userHasSource($feedSource)) {
            $sourceName = $feedSource->getName();
            $this->addFlash('error', "You haven't added $sourceName to your sources");

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('feed_source/show.html.twig', [
            'feed_source' => $feedSource,
        ]);
    }

    #[Route('/{id}/edit', name: 'feed_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FeedSource $feedSource): Response
    {
        if (!$this->userHasSource($feedSource)) {
            $this->addFlash('error', 'You cannot edit this source');

            return $this->redirectToRoute('dashboard_index');
        }

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
        if (!$this->userHasSource($feedSource)) {
            $this->addFlash('error', 'You cannot delete this source');

            return $this->redirectToRoute('dashboard_index');
        }

        if ($this->isCsrfTokenValid('delete'.$feedSource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($feedSource);
            $entityManager->flush();

            $this->addFlash('success', 'Source was deleted successfully');
        }

        return $this->redirectToRoute('feed_source_index');
    }
}
