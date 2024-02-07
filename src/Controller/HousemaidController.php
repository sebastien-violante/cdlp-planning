<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HousemaidController extends AbstractController
{
    #[Route('/housemaid', name: 'app_housemaid')]
    public function index(): Response
    {
        return $this->render('housemaid/index.html.twig', [
            'controller_name' => 'HousemaidController',
        ]);
    }

    #[Route('/housemaid/{month}/{year}', name: 'app_results_housemaid')]
    public function showResults(
        string $month,
        string $year
    ): Response {
        var_dump($month . ' ' . $year);
        die;
    }
}
