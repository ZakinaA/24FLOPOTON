<?php

namespace App\Controller;

use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/intervention', name: 'app_intervention_')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('intervention/index.html.twig', [
            'controller_name' => 'InterventionController',
        ]);
    }
    
    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine)
    {
            $repository = $doctrine->getRepository(Intervention::class);
            
            $interventions= $repository->findAll();
            return $this->render('intervention/lister.html.twig', [
                'pInterventions' => $interventions,
            ]); 
    }

}
