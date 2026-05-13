<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Form\Admin\TicketAdminType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tickets')]
class TicketAdminController extends AbstractController
{
    #[Route('/', name: 'admin_tickets_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/tickets/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_tickets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ticket = new Ticket();
        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket créé avec succès.');

            return $this->redirectToRoute('admin_tickets_index');
        }

        return $this->render('admin/tickets/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_tickets_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/tickets/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_tickets_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Ticket modifié avec succès.');

            return $this->redirectToRoute('admin_tickets_index');
        }

        return $this->render('admin/tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_tickets_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {

            $entityManager->remove($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_tickets_index');
    }

    #[Route('/debug-user', name: 'debug_user')]
    public function debugUser(): Response
    {
        return $this->json([
            'user' => $this->getUser()?->getUserIdentifier(),
            'roles' => $this->getUser()?->getRoles(),
        ]);
    }
}