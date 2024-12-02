<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $eleves = new Eleve();
        $form = $this->createForm(EleveType::class, $eleves);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $eleves = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleves);
            $entityManager->flush();
            
            //return $this->render('eleve/lister.html.twig', ['eleves' => $eleves,]);
            return $this->redirectToRoute('app_eleve_lister');
        } else  {
            return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
}
