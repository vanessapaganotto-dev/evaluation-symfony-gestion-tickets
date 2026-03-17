<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // mettre la date d'ouverture automatiquement
            $ticket->setDateOuverture(new \DateTime());

            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Ticket créé avec succès !');

            return $this->redirectToRoute('app_ticket');
        }

        return $this->render('ticket/index.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }
}