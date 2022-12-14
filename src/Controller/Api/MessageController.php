<?php

namespace App\Controller\Api;

use App\Controller\Mail\MailerController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Mail;
use App\Entity\Messages;
use App\Form\MailType;
use App\Repository\MailRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageController extends AbstractController
{
    #[Route('/api/sendmail', name: 'app_front_message')]
    public function index(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, MessagesRepository $messageRepository, MailerController $sendMail) : JsonResponse
    {
        
        $json = $request->getContent();
        $message = $serializer->deserialize($json, Messages::class, 'json');

        $errors = $validator->validate($message);
        if(count($errors) > 0) {
            $cleanErrors = [];

            foreach($errors AS $error) {
                
                $property = $error->getPropertyPath();
                $message = $error->getMessage();

                $cleanErrors[$property][] = $message;

            }

            return $this->json(['errors'=>$cleanErrors, 'status' => Response::HTTP_UNPROCESSABLE_ENTITY]); 
        }
        if ($message->getName() == "" || $message->getEmail() == "" || $message->getContent() == "")
        {
            return $this->json(['errors'=>'Veuillez renseigner tous les champs', 'status' => Response::HTTP_UNPROCESSABLE_ENTITY]); 
        }

      //  $manager = $doctrine->getManager();
    
        //$message->setCreatedAt(new \DateTimeImmutable());
       // $message->setStatus(1);
        

        //$manager->persist($message);
        //$manager->flush();

        $sendMail->sendEmailVisitor($message);
        $sendMail->sendEmailExploitant($message);
        return $this->json(['success' => 'Votre message a ??t?? envoy??', 'status'=> Response::HTTP_CREATED ]);
  
        
        
    }

    #[Route('/api/getnewmail', name: 'mail_get', methods: ["GET"])]
    public function getNewMail(MailRepository $mailRepository) : JsonResponse
    {
        $mails = $mailRepository->findBy(['status'=>1]);
        $mail = count($mails);

        return $this->json(['mail'=>$mail], Response::HTTP_OK, [], [
            'groups' => 'mail_get'
        ]);
    }

}
