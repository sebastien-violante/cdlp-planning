<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function seeRentalSchedule(
        ClientRepository $clientRepository,
    ): Response
    {
        $clients = $clientRepository->findAll();
        return $this->render('home/index.html.twig', [
            'clients' => $clients,
        ]);
    }
}