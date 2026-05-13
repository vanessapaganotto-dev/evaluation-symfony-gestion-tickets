<?php

namespace App\Controller\Admin;

use App\Repository\EtatRepository;
use App\Repository\ResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/debug')]
class DebugController extends AbstractController
{
    #[Route('/db', name: 'admin_debug_db')]
    public function db(
        EtatRepository $etatRepository,
        ResponsableRepository $responsableRepository
    ): Response
    {
        return $this->json([
            'etats' => array_map(fn($e) => $e->getNom(), $etatRepository->findAll()),
            'responsables' => array_map(fn($r) => $r->getNom(), $responsableRepository->findAll()),
        ]);
    }
}