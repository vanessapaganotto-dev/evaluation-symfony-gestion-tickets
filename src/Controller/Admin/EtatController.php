<?php

namespace App\Controller\Admin;

use App\Entity\Etat;
use App\Form\Admin\EtatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etat', name: 'admin_etat_')]
class EtatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {
        $etats = $em->getRepository(Etat::class)->findAll();
        return $this->render('admin/etat/index.html.twig', [
            'etats' => $etats,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Etat $etat, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'État mis à jour !');
            return $this->redirectToRoute('admin_etat_index');
        }

        return $this->render('admin/etat/edit.html.twig', [
            'etatForm' => $form->createView(),
        ]);
    }
}