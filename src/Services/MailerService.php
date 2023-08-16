<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\MailerInterface;


class MailerService 
{
    public function __construct(private MailerInterface $mailer){}
    
    public function sendEmail(): void 
    {
        $fromEmail = 'sebastien.violante@gmail.com';
        $toEmail = 'sebastien.violante@gmail.com';
        $email = (new Email())
        ->from($fromEmail)
        ->to($toEmail)
        ->subject('Corniche de la plage : nouvelle réservation')
        ->text('hello')
        ->html('<h3>Salut mon service de mail</h3>');
        //->context([
        //'client' => $client,
        //]);
        //$transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        //$mailer = new Mailer($transport);
        $this->mailer->send($email);
    }       
}

