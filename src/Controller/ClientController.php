<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Services\MailerService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\ClientRepository;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function addNewClient(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MailerService $mailerService,
    ): Response {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setCleaned(false);
            $client->setRed(rand(150,255));
            $client->setGreen(rand(150,255));
            $client->setBlue(rand(150,255));
            // Mailing
            $content = 
            '
                <h3>Nouvelle réservation</h3>
                <hr>
                <p>L\'appartement de Bénodet vient d\'être réservé par <strong>'.$client->getFirstname().'</strong> du '.$client->getArrivalDate()->format('j l Y').' au '.$client->getDepartureDate()->format('j l Y').'.</p>
                <p>Pensez à consulter le calendrier à l\'adresse : <i>'.$this->getParameter('SITE_ADDR').'</i></p>
            '
            ;
            $subject = 'nouvelle réservation';
            $mailerService->sendEmail($this->getParameter('MAILER_DSN'), $this->getParameter('MAIL_FROM'), $this->getParameter('MAIL_MAID'),$this->getParameter('MAIL_ADMIN'), $content, $subject);
            // Persisting new client
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();
        }

        return $this->render('client/index.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete', methods: ['POST', 'GET'])]
    public function deleteClient(
       ClientRepository $clientRepository,
       EntityManagerInterface $entityManagerInterface,
       int $id,
    ): Response {
        $client = $clientRepository->findOneBy(['id' => $id]);
        $entityManagerInterface->remove($client);
        $entityManagerInterface->flush();
        
        return $this->redirectToRoute('app_home');
    }

    #[Route('/cleaned/{id}', name: 'app_clean', methods: ['POST', 'GET'])]
    public function cleanedClient(
       ClientRepository $clientRepository,
       EntityManagerInterface $entityManagerInterface,
       MailerService $mailerService,
       int $id,
    ): Response {
        $client = $clientRepository->findOneBy(['id' => $id]);
        $client->setCleaned(true);
         // Mailing
         $content = 
            '
                <h3>Départ effectué</h3>
                <hr>
                <p>Le départ de <strong>'.$client->getFirstname().'</strong> vient d\'être effectué.</p>
                <p>Pensez à consulter le calendrier à l\'adresse : <i>https://cdlp.dev-uptoyou.fr</i></p>
            '
            ;
        $subject = 'départ du locataire';
        $mailerService->sendEmail($this->getParameter('MAILER_DSN'), $this->getParameter('MAIL_FROM'), $this->getParameter('MAIL_MAID'),$this->getParameter('MAIL_ADMIN'), $content, $subject);
        $entityManagerInterface->persist($client);
        $entityManagerInterface->flush();
        
        return $this->redirectToRoute('app_home');
    }

}
