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

        // Encoder mdp
        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $entityManager->persist($user);
        $entityManager->flush();

        // Flash : tu n’es pas connecté, juste créé
        $this->addFlash('success', 'Inscription réussie ! Veuillez vous connecter.');

        // Rediriger vers la page de login
        return new RedirectResponse($this->generateUrl('app_login'));
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
    $user->setEmail('admin@test.com');
    $user->setRoles(['ROLE_ADMIN']);
    $user->setPassword($userPasswordHasher->hashPassword($user, 'admin123'));
    
    $entityManager->persist($user);
    $entityManager->flush();
    
    return new Response('Utilisateur admin créé ! Email: admin@test.com / Mdp: admin123');
}
}