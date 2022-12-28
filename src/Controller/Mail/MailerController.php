<?php
// src/Controller/MailerController.php
namespace App\Controller\Mail;

use App\Entity\Messages;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/email/visitor')]
    public function sendEmailVisitor(Messages $mail)
    {
        $email = (new TemplatedEmail())
            ->from('message@crossfitdaemon.fr')
            ->to('crossfitdaemon@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('crossfitdaemon@gmail.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Votre message depuis le site crossfitdaemon.fr')
            ->htmlTemplate('mail/mailer/mailExploit.html.twig')
            ->context([
                'name' => $mail->getName(),
                'address' => $mail->getEmail(),
                'content' => $mail->getContent()
            ]);
        $this->mailer->send($email);
        
    }
   

    #[Route('/email/exploitant')]
    public function sendEmailExploitant(Messages $mail)
    {
        $address = $mail->getEmail();
        $email = (new TemplatedEmail())
            ->from('message@crossfitdaemon.fr')
            ->to($address)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('crossfitdaemon@gmail.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Nouveau message depuis votre site')
            ->htmlTemplate('mail/mailer/mailVisit.html.twig')
            ->context([
                'name' => $mail->getName(),
                'address' => $mail->getEmail(),
                'content' => $mail->getContent()
            ]);
        $this->mailer->send($email);
        
    }
}