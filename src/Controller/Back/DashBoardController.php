<?php

namespace App\Controller\Back;

use App\Repository\VisitorRepository;
use App\Repository\ProductsRepository;
use App\Service\VisitorCounter;
use App\Service\ProductsCounter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index(VisitorCounter $visitor, ProductsCounter $products, ProductsRepository $productsRepository): Response
    {
        
        $countVisitor = $visitor->getCountVisitor();
        $bestProduct = $products->getBestproduct();
        $activProducts = $products->getCountProductsStatus(1);
        $inactivProducts = $products->getCountProductsStatus(0);
        $products =  $productsRepository->findAll();
        return $this->render('back/main/index.html.twig', [
            'countVisitor' => $countVisitor,
            'bestProduct' => $bestProduct,
            'activProducts' => $activProducts,
            'inactivProducts' => $inactivProducts,
            'products' => $products
        ]);
    }
}
