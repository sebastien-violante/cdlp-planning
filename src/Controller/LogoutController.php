<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class LogoutController is the exit point of the app
 */
class LogoutController extends AbstractController
{
    /**
     * function logout is an empty function dedicated to exit the app. In security.yaml, logout redirects to login
     *
     * @return never
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET','POST'])]
    public function logout(): never
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
