<?php
// src/Controller/MailerController.php
namespace App\Controller\Mail;

use App\Entity\Messages;
use App\Entity\User;
use App\Repository\ExploitantRepository;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    private $mailer;
    private $exploit;

    public function __construct(MailerInterface $mailer, ExploitantRepository $exploit)
    {
        $this->mailer = $mailer;
        $this->exploit = $exploit;
    }

    #[Route('/email/visitor')]
    public function sendEmailVisitor(Messages $mail)
    {
        $exploit = $this->exploit->find(1);
        $email = (new TemplatedEmail())
            ->from('message@crossfitdaemon.fr')
            ->to($exploit->getMail())
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

    #[Route('/email/newuser')]
    public function sendEmailNewUser(User $user)
    {
        $exploit = $this->exploit->find(1);
        $address = $user->getEmail();
        $role = $user->getRoles(['role']);
        $email = (new TemplatedEmail())
            ->from('message@crossfitdaemon.fr')
            ->to($address)
            //->cc('cc@example.com')
            ->bcc($exploit->getMail())
            //->replyTo('crossfitdaemon@gmail.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Votre compte sur crossfitdaemon.fr')
            ->htmlTemplate('mail/mailer/mailNewUser.html.twig')
            ->context([
                'nameExploit' => $exploit->getName(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'address' => $address,
                'role' => $user->getRoles([0])
            ]);
        $this->mailer->send($email);
        
    }
}