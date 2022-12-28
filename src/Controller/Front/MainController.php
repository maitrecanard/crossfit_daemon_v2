<?php

namespace App\Controller\Front;

use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\ArticlesRepository;
use App\Repository\MessagesRepository;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_front_main')]
    public function index(Request $request, MessagesRepository $messagesRepository, ArticlesRepository $articlesRepository): Response
    {
        $article1 = $articlesRepository->find(1);
        $article2 = $articlesRepository->find(2);
        $article3 = $articlesRepository->find(3);
        $article4 = $articlesRepository->find(4);
        $article5 = $articlesRepository->find(5);
        $article6 = $articlesRepository->find(6);
        
        $message = New Messages();
        $form = $this->createForm(MessageType::class, $message);
      

        return $this->renderForm('front/main/index.html.twig', [
            'article1' => $article1->getContent(),
            'article2' => $article2->getContent(),
            'article3' => $article3->getContent(),
            'article4' => $article4->getContent(),
            'article5' => $article5,
            'article6' => $article6->getContent(),
            'form' => $form,
        ]);
    }
}
