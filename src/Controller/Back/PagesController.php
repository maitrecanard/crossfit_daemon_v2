<?php

namespace App\Controller\Back;

use App\Entity\HistoricMovement;
use App\Entity\Pages;
use App\Form\PagesType;
use App\Repository\HistoricMovementRepository;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/back/pages')]
class PagesController extends AbstractController
{
    #[Route('/', name: 'app_back_pages_index', methods: ['GET'])]
    public function index(PagesRepository $pagesRepository): Response
    {
        return $this->render('back/pages/index.html.twig', [
            'pages' => $pagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_pages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   

        $this->denyAccessUnlessGranted('POST_NEW', $this->getUser());
        $page = new Pages();
        $form = $this->createForm(PagesType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($page);
            $historicMovement = new HistoricMovement();
            $historicMovement->setName('Création');
            $historicMovement->setCreatedAt(new \DateTimeImmutable());
            $historicMovement->setUser($this->getUser());
            $historicMovement->setPage($page);
            $entityManager->persist($historicMovement);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_pages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/pages/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_pages_show', methods: ['GET'])]
    public function show(Pages $page, HistoricMovementRepository $historicMovementRepository): Response
    {
        return $this->render('back/pages/show.html.twig', [
            'page' => $page,
            'historical' => $historicMovementRepository->findBy(['page' => $page])
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_pages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pages $page, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PagesType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page->setUpdatedAt(new \DateTimeImmutable());
            $historicMovement = new HistoricMovement();
            $historicMovement->setName('Modification');
            $historicMovement->setUser($this->getUser());
            $historicMovement->setPage($page);
            $historicMovement->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($historicMovement);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_pages_show', ['id'=>$page->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/pages/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_pages_delete', methods: ['POST'])]
    public function delete(Request $request, Pages $page, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('POST_NEW', $this->getUser());
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_pages_index', [], Response::HTTP_SEE_OTHER);
    }
}
