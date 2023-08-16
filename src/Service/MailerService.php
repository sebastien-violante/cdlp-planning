<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;

class MailerService 
{
    public function sendEmail(MailerInterface $mailer) {
        $fromEmail = 'sebastien.violante@gmail.com';
        $toEmail = 'sebastien.violante@gmail.com';
        $email = (new Email())
        ->from($fromEmail)
        ->to($toEmail)
        ->subject('Corniche de la plage : nouvelle réservation')
        ->text('hello')
        ->html('<h3>Salut</h3>');
        //->context([
        //'client' => $client,
        //]);
        //$transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        //$mailer = new Mailer($transport);
        $mailer->send($email);
    }       
    }
}
