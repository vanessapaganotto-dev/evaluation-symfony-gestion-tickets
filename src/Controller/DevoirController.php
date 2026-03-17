<?php

namespace App\Controller;

use App\Entity\Devoir;
use App\Form\DevoirType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevoirController extends AbstractController
{
    #[Route('/devoir/new', name: 'devoir_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devoir = new Devoir();
        $form = $this->createForm(DevoirType::class, $devoir);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devoir);
            $entityManager->flush();

            $this->addFlash('success', 'Le devoir a été créé avec succès !');

            return $this->redirectToRoute('devoir_new');
        }

        return $this->render('devoir/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}