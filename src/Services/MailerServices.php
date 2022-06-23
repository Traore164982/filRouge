<?php
namespace App\Services;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class MailerServices{

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    /**
     * @param User $user;
     */
    public function sendEmail($user, $subject="Création de Compte"){
        $from = "Brazilburger@gmail.com";
        $email = (new Email())
        ->from($from)
        ->to($user->getEmail())
        ->subject($subject)
        ->html($this->twig->render('emails/Registration.html.twig',
        [
            'token'=>$user->getToken(),
            'subject'=>$subject,
            'name'=>$user->getNom()
        ]));
        $this->mailer->send($email);        
    }
}