<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Responsable;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    // Injection du hasher pour les mots de passe
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --- Categories ---
        $cats = ['Incident', 'Panne', 'Evolution', 'Anomalie', 'Info'];
        foreach ($cats as $c) {
            $cat = new Categorie();
            $cat->setNom($c);
            $manager->persist($cat);
        }

        // --- Etats ---
        $etats = ['Nouveau', 'Ouvert', 'Résolu', 'Fermé'];
        foreach ($etats as $e) {
            $etat = new Etat();
            $etat->setNom($e);
            $manager->persist($etat);
        }

        // --- Responsables ---
        $r1 = new Responsable();
        $r1->setNom('Alice D')->setEmail('alice@example.com');
        $manager->persist($r1);

        $r2 = new Responsable();
        $r2->setNom('Bob M')->setEmail('bob@example.com');
        $manager->persist($r2);

        // --- Users ---
        $admin = new User();
        $admin->setEmail('admin@test.com')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $staff = new User();
        $staff->setEmail('staff@test.com')
              ->setRoles(['ROLE_USER'])
              ->setPassword($this->passwordHasher->hashPassword($staff, 'staff123'));
        $manager->persist($staff);

        $manager->flush(); // envoie tout en bdd
    }
}