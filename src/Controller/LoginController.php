<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * class LoginController allows to authenticate user
 */
class LoginController extends AbstractController
{
    /**
     * function login is dedicated to app authentication. It's route is the entrance point
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/', name: 'app_login')]
    public function login(
        AuthenticationUtils $authenticationUtils
    ): Response {
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/index.html.twig', [
             'error'         => $error,
         ]);
    }
}
