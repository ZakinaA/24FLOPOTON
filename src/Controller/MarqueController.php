<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Marque;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/marque', name: 'app_marque_')]
class MarqueController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_marque_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Marque::class);
        $entities = $repository->findAll();

        $headers = ['Libelle'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getLibelle(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Marque',
            'display' => 'Marque',
            'display_plural' => 'Marques',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/listerold', name: 'listerold')]
    function marqueLister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Marque::class);
        $marques= $repository->findAll();

        return $this->render('marque/lister.html.twig', ['mMarque' => $marques,]);
    }
}