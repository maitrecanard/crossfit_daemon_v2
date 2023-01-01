<?php

namespace App\Controller\Back;

use App\Entity\HistoricMovement;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\HistoricMovementRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/partner')]
class PartnerController extends AbstractController
{
    #[Route('/', name: 'app_back_partner_index', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository): Response
    {
        return $this->render('back/partner/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartnerRepository $partnerRepository, HistoricMovementRepository $historicMovementRepository): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner->setCreatedAt(new \DateTimeImmutable());
            $partnerRepository->add($partner, true);

            $user = $this->getUser();
            $historicMovement = New HistoricMovement();
            $historicMovement->setUser($user);
            $historicMovement->setPartner($partner);
            $historicMovement->setName('Création');
            $historicMovement->setCreatedAt(new \DateTimeImmutable());
            $historicMovementRepository->add($historicMovement, true);

            return $this->redirectToRoute('app_back_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_partner_show', methods: ['GET'])]
    public function show(Partner $partner, HistoricMovementRepository $historicMovementRepository): Response
    {
        $historic  = $partner->getHistoricMovements()->getValues();
        return $this->render('back/partner/show.html.twig', [
            'partner' => $partner,
            'historical' => $historic
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            return $this->redirectToRoute('app_back_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $partnerRepository->removeHistoricalPartner($partner, true);
        }

        return $this->redirectToRoute('app_back_partner_index', [], Response::HTTP_SEE_OTHER);
    }
}
