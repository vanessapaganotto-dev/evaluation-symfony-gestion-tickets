<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Etat;
use App\Form\TicketPublicType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketPublicController extends AbstractController
{
    #[Route('/ticket/new', name: 'ticket_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $ticket = new Ticket();

        $form = $this->createForm(TicketPublicType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etat = $em->getRepository(Etat::class)->findOneBy(['nom' => 'Nouveau']);
            $ticket->setEtat($etat);
            $ticket->setResponsable(null);

            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Votre ticket a été créé avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('ticket/new.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }

    #[Route('/tickets', name: 'ticket_list')]
    #[IsGranted('ROLE_ADMIN')] // Protection ajoutée : accès restreint aux admins
    public function list(EntityManagerInterface $em): Response
    {
        $tickets = $em->getRepository(Ticket::class)->findBy(
            [], 
            ['dateOuverture' => 'DESC']
        );

        return $this->render('ticket/list.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}