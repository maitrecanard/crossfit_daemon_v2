<?php

namespace App\Controller\Back;

use App\Entity\Categories;
use App\Entity\HistoricMovement;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\HistoricMovementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_back_categories_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('back/categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository, HistoricMovementRepository $historicMovementRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $categoriesRepository->add($category, true);

            $historic = new HistoricMovement;
            $historic->setName('Création');
            $historic->setCategory($category);
            $historic->setUser($user);
            $historic->setCreatedAt(new \DateTimeImmutable());

            $historicMovementRepository->add($historic, true);
            

            return $this->redirectToRoute('app_back_categories_show', ['id'=> $category->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_categories_show', methods: ['GET'])]
    public function show(Categories $category,HistoricMovementRepository $historicMovementRepository): Response
    {
        $historic = $category->getHistoricMovements()->getValues();
    
        $products = $category->getProducts()->getValues();
        return $this->render('back/categories/show.html.twig', [
            'historical' => $historic,
            'category' => $category,
            'products' => $products
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository,HistoricMovementRepository $historicMovementRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $historic = new HistoricMovement;
            $historic->setName('Modification');
            $historic->setCategory($category);
            $historic->setUser($user);
            $historic->setCreatedAt(new \DateTimeImmutable());

            $historicMovementRepository->add($historic, true);

            $categoriesRepository->add($category, true);

            return $this->redirectToRoute('app_back_categories_show', ['id'=> $category->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoriesRepository->removeCategoryHistoric($category, true);
        }

        return $this->redirectToRoute('app_back_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
