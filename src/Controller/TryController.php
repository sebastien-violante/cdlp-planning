<?php

namespace App\Controller;

use App\Repository\ClientRepository;
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
        MailerInterface $mailer,
        ClientRepository $clientRepository
    ): Response
    {
        $client = $clientRepository->findOneBy(['firstname' => 'Robert']);       
        return $this->render('emails/try.html.twig', [
            'client' => $client
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