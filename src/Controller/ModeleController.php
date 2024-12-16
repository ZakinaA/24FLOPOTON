<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Modele;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/modele', name: 'app_modele_')]
class ModeleController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_modele_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Modele::class);
        $entities = $repository->findAll();

        $headers = ['Libelle'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getNom(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Modele',
            'display' => 'Modèle',
            'display_plural' => 'Modèles',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/listerold', name: 'listerold')]
    function modeleLister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Modele::class);
        $modeles= $repository->findAll();

        return $this->render('modele/lister.html.twig', ['mModele' => $modeles,]);
    }
}