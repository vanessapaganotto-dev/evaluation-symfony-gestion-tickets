<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // Encoder le mot de passe
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // Connecter l'utilisateur automatiquement
            $security->login($user, 'form_login', 'main');

            // Ajouter un message flash
            $this->addFlash('success', 'Inscription réussie ! Vous êtes connecté.');

            // Rediriger vers la page d'accueil
            return new RedirectResponse($this->generateUrl('app_home'));
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    // Méthode pour créer un utilisateur test (optionnelle)
    #[Route('/create-test-user', name: 'app_create_test_user')]
    public function createTestUser(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword($userPasswordHasher->hashPassword($user, 'motdepasse123'));

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Utilisateur test créé !');
    }
}