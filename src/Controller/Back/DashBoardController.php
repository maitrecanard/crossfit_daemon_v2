<?php

namespace App\Controller\Back;

use App\Entity\Exploitant;
use App\Repository\ExploitantRepository;
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
    public function index(VisitorCounter $visitor): Response
    {
        $countVisitor = $visitor->getCountVisitor();
        return $this->render('back/main/index.html.twig', [
            'countVisitor' => $countVisitor,
            
        ]);
    }
}
