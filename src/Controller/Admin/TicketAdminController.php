<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Entity\Etat;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketAdminController extends AbstractController
{
    #[Route('/ticket/new', name: 'ticket_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $ticket = new Ticket();
        $ticket->setDateOuverture(new \DateTime()); // date ouverture automatique

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Définir l'état par défaut "Nouveau"
            $etat = $em->getRepository(Etat::class)->findOneBy(['nom' => 'Nouveau']);
            $ticket->setEtat($etat);

            // Pas de responsable assigné au départ
            $ticket->setResponsable(null);

            // Persister et enregistrer en base
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Votre ticket a été créé avec succès !');

            // Redirection après création (vers accueil ou liste tickets)
            return $this->redirect('/');
        }

        return $this->render('ticket/new.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }
}