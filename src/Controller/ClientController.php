<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\UnaviabilityType;
use App\Services\MailerService;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ClientController supports methods for adding, deleting and modifying a client
 */
class ClientController extends AbstractController
{
    /**
     * function AddNewClient allows to add a new customer by entering his reservation details. It also generates an e-mail
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManagerInterface
     * @param MailerService $mailerService
     * @return Response
     */
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
            // By default, the parameter cleaned is false to indicate that his departure hasn't been done yet
            $client->setCleaned(false);
            $client->setNoticed(false);
            // The parameters red, green and blue are used to generate a random color for each client (used for card display)
            $client->setRed(rand(150, 255));
            $client->setGreen(rand(150, 255));
            $client->setBlue(rand(150, 255));
            // Parameters used for the mailing
            $subject = "nouvelle réservation";
            $title = "Nouvelle réservation";
            $beginning = "La réservation de";
            $middle = "pour la période";
            $end = "vient d'être ajoutée";
            $mailerService->sendEmail($this->getParameter('MAILER_DSN'), $this->getParameter('MAIL_FROM'), $this->getParameter('MAIL_MAID'), $this->getParameter('MAIL_MAID_2'), $this->getParameter('MAIL_ADMIN'), $subject, $title, $beginning, $middle, $end, $client, $this->getParameter('SITE_ADDR'));
            // Once the mail is send, the new client is persisted in database
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();
            // Once the client is persisted, the user is redirected to the home page to the rent list
            return $this->redirectToRoute('app_home');
        }

        return $this->render('client/index.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }

    /**
     * function AddNewClient allows to add a new customer by entering his reservation details. It also generates an e-mail
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManagerInterface
     * @param MailerService $mailerService
     * @return Response
     */
    #[Route('/indisponibilité', name: 'app_unaviability')]
    public function addNewUnavialability(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
    ): Response {
        $client = new Client();
        $form = $this->createForm(UnaviabilityType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // By default, the parameter cleaned is false to indicate that his departure hasn't been done yet
            $client->setCleaned(false);
            $client->setFirstname("Housemaid");
            $client->setInitial("X");
            // Once the mail is send, the new client is persisted in database
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();
            // Once the client is persisted, the user is redirected to the home page to the rent list
            return $this->redirectToRoute('app_home');
        }

        return $this->render('client/unaviability.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }

    /**
     * * function deleteClient allows to delete a client once it's departure is validated. Function granted to admin role only
     * @param int $id
     * @param EntityManagerInterface $entityManagerInterface
     * @param ClientRepository $clientRepository
     * @return Response
     */
    #[Route('/delete/{id}', name: 'app_delete', methods: ['POST', 'GET'])]
    public function deleteClient(
        ClientRepository $clientRepository,
        EntityManagerInterface $entityManagerInterface,
        MailerService $mailerService,
        int $id,
    ): Response {
        // The client whose id is transmited by click on delete icon is removed from the database
        $client = $clientRepository->findOneBy(['id' => $id]);
        $entityManagerInterface->remove($client);
        $entityManagerInterface->flush();
        if ($client->isCleaned() == false) {
            // A mail is send to the owner to indicate that the rental is canceled before it's arrival
            $subject = "annulation de réservation";
            $title = "Séjour annulé";
            $beginning = "Le séjour de";
            $middle = "locataire";
            $end = "vient d'être annulé";
            $mailerService->sendEmail($this->getParameter('MAILER_DSN'), $this->getParameter('MAIL_FROM'), $this->getParameter('MAIL_MAID'), $this->getParameter('MAIL_ADMIN'), $subject, $title, $beginning, $middle, $end, $client, $this->getParameter('SITE_ADDR'));
        }

        return $this->redirectToRoute('app_home');
    }

    /**
     * function setNoticed allows to indicate when a client has been sent the arrival documents
     * @param int $id
     * @param EntityManagerInterface $entityManagerInterface
     * @param ClientRepository $clientRepository
     * @return Response
     */
    #[Route('/notifié/{id}', name: 'app_noticed', methods: ['POST', 'GET'])]
    public function setNoticed(
        ClientRepository $clientRepository,
        EntityManagerInterface $entityManagerInterface,
        int $id,
    ): Response {
        $client = $clientRepository->findOneBy(['id' => $id]);
        $client->setNoticed(1);
        $entityManagerInterface->persist($client);
        $entityManagerInterface->flush();
        return $this->json([
            'code' => 200,
            'message' => "mise à jour effectuée",
            'status' => 1
        ], 200);
    }


    /**
     * function cleanedClient allows to indicate the departure of a client. A mail is generated to warn the owner immediatly
     * @param int $id
     * @param EntityManagerInterface $entityManagerInterface
     * @param ClientRepository $clientRepository
     * @param MailerService $mailerService
     * @return Response
     */
    #[Route('/cleaned/{id}', name: 'app_clean', methods: ['POST', 'GET'])]
    public function cleanedClient(
        ClientRepository $clientRepository,
        EntityManagerInterface $entityManagerInterface,
        MailerService $mailerService,
        int $id,
    ): Response {
        $client = $clientRepository->findOneBy(['id' => $id]);
        // The client parameter cleaned is sert to tru to indicate that it's departure has been validated
        $client->setCleaned(true);
        $entityManagerInterface->flush();
        // A mail is send to the owner to indicate that the departure has been done
        $subject = "départ effectué";
        $title = "Nouveau départ";
        $beginning = "Le départ de";
        $middle = "locataire";
        $end = "vient d'être effectué";
        $mailerService->sendEmail($this->getParameter('MAILER_DSN'), $this->getParameter('MAIL_FROM'), $this->getParameter('MAIL_OWNER'), $this->getParameter('MAIL_ADMIN'), $subject, $title, $beginning, $middle, $end, $client, $this->getParameter('SITE_ADDR'));

        return $this->redirectToRoute('app_home');
    }
}
