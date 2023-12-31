<?php

namespace App\Controller;

use Datetime;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * class HomeController allows to render the list of rentals
 */
class HomeController extends AbstractController
{
    /**
     * function seeRentalSchedule display the rentals in the form of cards
     *
     * @param ClientRepository $clientRepository
     * @return Response
     */
    #[Route('/home', name: 'app_home')]
    public function seeRentalSchedule(
        ClientRepository $clientRepository,
    ): Response
    {
        // All the clients are displayed but sorted by arrival date, thanks to the findBySortedAvvilDate method in the ClientRepository
        $clients = $clientRepository->findBySortedArrivalDate();
        $dateNow = new \Datetime();    
        return $this->render('home/index.html.twig', [
            'clients' => $clients,
            'dateNow' => $dateNow,
        ]);
    }
}
