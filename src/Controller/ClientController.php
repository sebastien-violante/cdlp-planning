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
        MailerInterface $mailer,
    ): Response {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setCleaned(false);
            // MAILING
            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
            $toEmail = 'sebastien.violante@gmail.com';
            
            $email = (new TemplatedEmail())
            ->from(new Address('bastien.c@dev-uptoyou.fr', 'Appartement Bénodet'))
            ->to($toEmail)
            //->cc($ccEmail)
            ->subject('Corniche de la plage : nouvelle réservation')
            ->html('
            <h3>Nouvelle réservation</h3>
            <hr>
            <p>L\'appartement de Bénodet vient d\'être réservé par <strong>'.$client->getFirstname().'</strong> du '.$client->getArrivalDate()->format('j l Y').' au '.$client->getDepartureDate()->format('j l Y').'.</p>
            <p>Pensez à consulter le calendrier à l\'adresse : <i>https://cdlp.dev-uptoyou.fr</i></p>
            ')
            ;
            
            $mailer->send($email);
            // persisting new client
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
       int $id,
    ): Response {
        $client = $clientRepository->findOneBy(['id' => $id]);
        $client->setCleaned(true);
        $entityManagerInterface->persist($client);
        $entityManagerInterface->flush();
        
        return $this->redirectToRoute('app_home');
    }

}
