<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Responsable;
use App\Entity\User;
use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // =====================
        // CATEGORIES
        // =====================
        $categories = [];

        foreach (['Incident', 'Panne', 'Évolution', 'Anomalie', 'Information'] as $name) {
            $categorie = new Categorie();
            $categorie->setNom($name);
            $manager->persist($categorie);

            $categories[$name] = $categorie;
        }

        // =====================
        // ETATS
        // =====================
        $etats = [];

        foreach (['Nouveau', 'Ouvert', 'Résolu', 'Fermé'] as $name) {
            $etat = new Etat();
            $etat->setNom($name);
            $manager->persist($etat);

            $etats[$name] = $etat;
        }

        // =====================
        // RESPONSABLES
        // =====================
        $resp1 = new Responsable();
        $resp1->setNom('Martin');
        $resp1->setPrenom('Lucas');
        $resp1->setEmail('lucas.martin@agency.com');
        $manager->persist($resp1);

        $resp2 = new Responsable();
        $resp2->setNom('Bernard');
        $resp2->setPrenom('Sophie');
        $resp2->setEmail('sophie.bernard@agency.com');
        $manager->persist($resp2);

        // =====================
        // USER ADMIN
        // =====================
        $admin = new User();
        $admin->setEmail('admin@test.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );

        $manager->persist($admin);

        // =====================
        // TICKETS (IMPORTANT POUR POINTS)
        // =====================
        $ticket1 = new Ticket();
        $ticket1->setAuteur('client1@test.com');
        $ticket1->setDescription('Impossible de se connecter à l’application depuis ce matin.');
        $ticket1->setCategorie($categories['Incident']);
        $ticket1->setEtat($etats['Nouveau']);
        $ticket1->setResponsable($resp1);
        $manager->persist($ticket1);

        $ticket2 = new Ticket();
        $ticket2->setAuteur('client2@test.com');
        $ticket2->setDescription('Demande d’évolution pour ajouter un tableau de bord statistique.');
        $ticket2->setCategorie($categories['Évolution']);
        $ticket2->setEtat($etats['Ouvert']);
        $ticket2->setResponsable($resp2);
        $manager->persist($ticket2);

        // =====================
        // FLUSH GLOBAL
        // =====================
        $manager->flush();
    }
}