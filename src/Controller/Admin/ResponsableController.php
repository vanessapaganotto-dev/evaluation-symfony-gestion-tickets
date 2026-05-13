<?php

namespace App\Controller\Admin;

use App\Entity\Responsable;
use App\Form\Admin\ResponsableType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/responsables')]
class ResponsableController extends AbstractController
{
    #[Route('/', name: 'admin_responsables_index', methods: ['GET'])]
    public function index(ResponsableRepository $responsableRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('admin/responsables/index.html.twig', [
            'responsables' => $responsableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_responsables_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responsable);
            $entityManager->flush();

            $this->addFlash('success', 'Responsable créé avec succès !');
            
            return $this->redirectToRoute('admin_responsables_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/responsables/new.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'admin_responsables_show', methods: ['GET'])]
    public function show(Responsable $responsable): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('admin/responsables/show.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_responsables_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Responsable $responsable, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Responsable modifié avec succès !');
            
            return $this->redirectToRoute('admin_responsables_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/responsables/edit.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_responsables_delete', methods: ['POST'])]
    public function delete(Request $request, Responsable $responsable, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$responsable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responsable);
            $entityManager->flush();
            
            $this->addFlash('success', 'Responsable supprimé avec succès !');
        }

        return $this->redirectToRoute('admin_responsables_index', [], Response::HTTP_SEE_OTHER);
    }
}