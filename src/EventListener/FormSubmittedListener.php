<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use App\Event\FormSubmittedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormSubmittedListener implements EventSubscriberInterface
{

    private $mailer;
    private $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.submitted' => 'onFormSubmitted',
        ];
    }

    public function onFormSubmitted(FormSubmittedEvent $event)
    {
        $contact = $event->getFormData();

        // Je ne recupere que les valeurs qui m'interesse pour le log
        $contactFirstname = $contact['firstname'];
        $contactLastname = $contact['lastname'];
        $contactEmail = $contact['email'];
        $contactComment = $contact['comment'];

        // Log pour la réception d'un formulaire soumis
        $this->logger->info('Le Formulaire soumis : ' . json_encode([
            'firstname' => $contactFirstname,
            'lastname' => $contactLastname,
            'email' => $contactEmail,
            'comment' => $contactComment,
        ]));


        // EMAIL
        $email = (new TemplatedEmail())
        ->from($contact['email'])
        ->to('admin@example.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Formulaire de Contact')
        ->htmlTemplate('emails/contact.html.twig')

        // pass variables (name => value) to the template
        ->context([
            'contact' => $contact
        ]);
        // On récupère l'addresse mail de celui qui envoie
        $headerFrom = $email->getFrom();
        $from = $headerFrom[0]->getAddress();
        // On récupère l'addresse mail de celui qui reçoit
        $headerTo = $email->getTo();
        $to = $headerTo[0]->getAddress();
        // On récupère le sujet du mail
        $subject = $email->getSubject();
        // On récupère le context du contact
        $context = $email->getContext();
        $contactInfo = $context['contact'];
        $infoFirstname = $contactInfo['firstname'];
        $infoLastname = $contactInfo['lastname'];
        $infoEmail = $contactInfo['email'];
        $infoComment = $contactInfo['comment'];

        
        $this->logger->info('Le Formulaire envoyé : ' . json_encode([
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'firstname' => $infoFirstname,
            'lastname' => $infoLastname,
            'email' => $infoEmail,
            'comment' => $infoComment,
        ]));
        
        $this->mailer->send($email);
    }
}