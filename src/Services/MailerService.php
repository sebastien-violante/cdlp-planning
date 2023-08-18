<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService 
{
    public function __construct(private MailerInterface $mailer){}
    
    public function sendEmail($dsn, $fromEmail, $toEmail, $ccEmail, $content, $subject, $client): void 
    {
        /* $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);
        $email = (new TemplatedEmail())
            ->from(new Address($fromEmail, 'Appartement Bénodet'))
            ->to($toEmail)
            ->cc($ccEmail)
            ->subject('Corniche de la plage : '.$subject)
            ->html($content)
            //->htmlTemplate('emails/rentalEmail.html.twig')
            ;
        $mailer->send($email); */

        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);
        $email = (new TemplatedEmail())
            ->from(new Address($fromEmail, 'Appartement Bénodet'))
            ->to($toEmail)
            ->cc($ccEmail)
            ->subject('Corniche de la plage : '.$subject)
            ->htmlTemplate('try.html.twig')
            ->context([
                'client' => $client
            ])
            ;
        $loader = new FilesystemLoader('/home/sebastienviolante/SymfonyProjects/cdlp/templates/emails');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);
        $mailer->send($email);
    }       
}

