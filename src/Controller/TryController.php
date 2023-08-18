<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TryController extends AbstractController
{
    #[Route('/try', name: 'app_try')]
    public function index(
        MailerInterface $mailer
    ): Response
    {
        $transport = Transport::fromDsn($this->getParameter('MAILER_DSN'));
        $mailer = new Mailer($transport);
        
        $email = (new TemplatedEmail())
        ->from('sebastien.violante@gmail.com')
        ->to(new Address('sebastien.violante@gmail.com'))
        ->subject('Hello World')
        ->htmlTemplate('try.html.twig')
        ->context([]);

        $loader = new FilesystemLoader('/home/sebastienviolante/SymfonyProjects/cdlp/templates/emails');

        $twigEnv = new Environment($loader);

        $twigBodyRenderer = new BodyRenderer($twigEnv);

        $twigBodyRenderer->render($email);

        $mailer->send($email);

        
        return $this->render('try/index.html.twig', [
            'controller_name' => 'TryController',
        ]);
    }
}
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