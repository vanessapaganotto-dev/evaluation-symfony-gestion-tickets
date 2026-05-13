<?php

namespace App\Controller\Admin;

use App\Entity\Etat;
use App\Form\Admin\EtatType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/etats')]
class EtatController extends AbstractController
{
    #[Route('/', name: 'admin_etats_index', methods: ['GET'])]
    public function index(EtatRepository $etatRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('admin/etats/index.html.twig', [
            'etats' => $etatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_etats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $etat = new Etat();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etat);
            $entityManager->flush();

            $this->addFlash('success', 'État créé avec succès !');
            
            return $this->redirectToRoute('admin_etats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etats/new.html.twig', [
            'etat' => $etat,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'admin_etats_show', methods: ['GET'])]
    public function show(Etat $etat): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('admin/etats/show.html.twig', [
            'etat' => $etat,
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_etats_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etat $etat, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'État modifié avec succès !');
            
            return $this->redirectToRoute('admin_etats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etats/edit.html.twig', [
            'etat' => $etat,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_etats_delete', methods: ['POST'])]
    public function delete(Request $request, Etat $etat, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$etat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etat);
            $entityManager->flush();
            
            $this->addFlash('success', 'État supprimé avec succès !');
        }

        return $this->redirectToRoute('admin_etats_index', [], Response::HTTP_SEE_OTHER);
    }
}