<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        // récup dernier username saisi
        $lastUsername = $authUtils->getLastUsername();
        // récup erreur éventuelle
        $error = $authUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère la déconnexion
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}