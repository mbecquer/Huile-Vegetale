<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $render;

    public function __construct(\Swift_Mailer $mailer, Environment $render)
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }
    public function notify(Contact $contact)
    {

        $message = (new \Swift_Message("Demande de renseignement de : " . $contact->getFirstname() . "  " . $contact->getLastname()))
            ->setFrom("agence@monagence.fr")
            ->setTo($contact->getEmail())
            ->setBody($this->render->render('notification/email.html.twig', [
                "contact" => $contact
            ]), 'text/html');


        $this->mailer->send($message);
    }
}
