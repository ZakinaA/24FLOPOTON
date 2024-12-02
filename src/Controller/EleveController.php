<?php

namespace App\Controller;

use App\Entity\Eleve;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/eleve', name: 'app_eleve_')]

class EleveController extends AbstractController
{
    #[Route('/index', name: 'index')]

    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }
    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Eleve::class);
        
        $eleves= $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
            'pEleves' => $eleves,
        ]); 
    }
}
