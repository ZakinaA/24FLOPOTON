<?php

namespace App\Controller;

use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\InterventionType;


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
    #[Route('/ajouter', name:'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $intervention = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_intervention_consulter', [
                'id' => $intervention->getId(),
            ]);
        }
        else
        {
            return $this->render('intervention/ajouter.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}
