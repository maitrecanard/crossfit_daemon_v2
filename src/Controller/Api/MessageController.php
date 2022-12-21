<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Mail;
use App\Entity\Messages;
use App\Form\MailType;
use App\Repository\MailRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageController extends AbstractController
{
    #[Route('/front/message', name: 'app_front_message')]
    public function index(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, MailRepository $mailRepository) : JsonResponse
    {
        
        $json = $request->getContent();
        
        $mail = $serializer->deserialize($json, Messages::class, 'json');
        $errors = $validator->validate($mail);
        if(count($errors) > 0) {
            $cleanErrors = [];

            foreach($errors AS $error) {
                
                $property = $error->getPropertyPath();
                $message = $error->getMessage();

                $cleanErrors[$property][] = $message;

            }

            return $this->json($cleanErrors, Response::HTTP_UNPROCESSABLE_ENTITY); 
        }

        $manager = $doctrine->getManager();
        
        $manager->persist($mail);
        $manager->flush();
        $mail->setCreatedAt(new \DateTimeImmutable());
        $mail->setStatus(1);
        $mailRepository->add($mail, true);

        return $this->json(['success' => 'Mail send'], Response::HTTP_CREATED );
        
    }

}
