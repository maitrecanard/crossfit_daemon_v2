<?php

namespace App\Controller\Back;


use App\Entity\Messages;
use App\Form\MailType;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/mail')]
class MailController extends AbstractController
{
    #[Route('/', name: 'app_back_mail_index', methods: ['GET'])]
    public function index(MessagesRepository $mailRepository): Response
    {
        return $this->render('back/mail/index.html.twig', [
            'mails' => $mailRepository->findBy([ ],['id'=> 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_back_mail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessagesRepository $mailRepository): Response
    {
        $mail = new Messages();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailRepository->add($mail, true);

            return $this->redirectToRoute('app_back_mail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/mail/new.html.twig', [
            'mail' => $mail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_mail_show', methods: ['GET'])]
    public function show(Messages $mail, MessagesRepository $mailRepository): Response
    {
        $mail->setStatus(2);
        $mailRepository->save($mail, true);

        return $this->render('back/mail/show.html.twig', [
            'mail' => $mail,
        ]);
    }

    #[Route('/{id}', name: 'app_back_mail_delete', methods: ['POST'])]
    public function delete(Request $request, Messages $mail, MessagesRepository $mailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mail->getId(), $request->request->get('_token'))) {
            $mailRepository->remove($mail, true);
        }

        return $this->redirectToRoute('app_back_mail_index', [], Response::HTTP_SEE_OTHER);
    }
}
