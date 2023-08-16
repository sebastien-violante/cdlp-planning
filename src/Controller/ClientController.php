<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Email;
use App\Repository\ClientRepository;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

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
            // sending email to advise household help
            $fromEmail = 'bastien.c@dev-uptoyou.fr';
            $toEmail = 'sebastien.violante@gmail.com';
            $email = (new Email())
            ->from($fromEmail)
            ->to($toEmail)
            ->subject('Corniche de la plage : nouvelle réservation')
            ->text('Une nouvelle réservation a été effectuée !')
            ->html('<h1>Une nouvelle réservation a été effectuée !</h1>');
            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
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
