<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\HistoricMovementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoricMovementController extends AbstractController
{
    #[Route('/back/historic/movement/{id}', name: 'app_back_historical_movement')]
    public function index(User $user, HistoricMovementRepository $historicMovementRepository): Response
    {
        
        return $this->render('back/historic/index.html.twig', [
            'historical' => $historicMovementRepository->findBy(['user' => $user],['created_at' => 'DESC'])
        ]);
    }
}
