<?php

namespace App\Controller\Front;

use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\MessagesRepository;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_front_main')]
    public function index(Request $request, MessagesRepository $messagesRepository): Response
    {
        $message = New Messages();
        $form = $this->createForm(MessageType::class, $message);
      

        return $this->renderForm('front/main/index.html.twig', [
            'form' => $form,
        ]);
    }
}
