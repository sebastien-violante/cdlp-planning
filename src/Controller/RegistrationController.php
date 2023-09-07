<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * class RegistrationController allows to register a new user and to give him a role
 */
class RegistrationController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    
    /**
     * function register allows to register a user, based on several details and to give him a role (chosen with the form). It's granted to adm role only
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Route('/registration', name: 'app_registration')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user= $form->getData();
            $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        };
        
        return $this->render('registration/index.html.twig', [
            'formRegister' => $form->createView(),
        ]);
    }
}
