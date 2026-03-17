<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Form\Admin\TicketAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tickets', name: 'admin_tickets_')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {
        $tickets = $em->getRepository(Ticket::class)->findAll();

        return $this->render('admin/tickets/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Ticket $ticket, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Ticket mis à jour !');
            return $this->redirectToRoute('admin_tickets_index');
        }

        return $this->render('admin/tickets/edit.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }
}