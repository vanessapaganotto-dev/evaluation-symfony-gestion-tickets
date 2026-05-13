<?php
namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Etat;
use App\Form\TicketPublicType;  // ← CHANGÉ ICI
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $ticket = new Ticket();
        
        // ✅ FIX : $form = 
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

        return $this->render('home/index.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }
}