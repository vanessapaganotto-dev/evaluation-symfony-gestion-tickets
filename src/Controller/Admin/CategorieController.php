<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\Admin\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Categorie::class)->findAll();
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Catégorie mise à jour !');
            return $this->redirectToRoute('admin_categories_index');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'categorieForm' => $form->createView(),
        ]);
    }
}