<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\Admin\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categories')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'admin_categories_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie créée avec succès !');

            return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categories/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_categories_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/categories/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Catégorie modifiée avec succès !');

            return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categories/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {

            $entityManager->remove($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie supprimée avec succès !');
        }

        return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}