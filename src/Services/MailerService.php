<?php

namespace App\Services;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService 
{
    public function __construct(private MailerInterface $mailer){}
    
    public function sendEmail($dsn, $fromEmail, $toEmail, $ccEmail, $content, $subject): void 
    {
        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);
        $email = (new TemplatedEmail())
            ->from(new Address($fromEmail, 'Appartement Bénodet'))
            ->to($toEmail)
            ->cc($ccEmail)
            ->subject('Corniche de la plage : '.$subject)
            ->html($content)
            //->htmlTemplate('emails/rentalEmail.html.twig')
            ;
        $mailer->send($email);
    }       
}

