<?php

namespace App\Controller\Back;

use App\Repository\VisitorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\VisitorCounter;

class VisitorController extends AbstractController
{
    #[Route('/back/visitor', name: 'app_back_visitor')]
    public function index(VisitorRepository $visitorRepository, VisitorCounter $visitorCounter): Response
    {
        $visitor = $visitorRepository->findAll();
        $countDay = $visitorCounter->getCountVisitor();
        $visitorCount = count($visitor);
        return $this->render('back/visitor/index.html.twig', [
            'visitorCount' => $visitorCount,
            'countDay' => $countDay
        ]);
    }
}
