<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/contrat', name: 'app_contrat_')]

class ContratController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('contrat/index.html.twig', [
            'controller_name' => 'ContratController',
        ]);
    }
    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Contrat::class);
        
        $contrats= $repository->findAll();
        return $this->render('contrat/lister.html.twig', [
            'pContrats' => $contrats,
        ]); 
    }
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $contrats = new Contrat();
        $form = $this->createForm(ContratType::class, $contrats);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $contrats = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contrats);
            $entityManager->flush();
            
            //return $this->render('contrat/lister.html.twig', ['contrats' => $contrats,]);
            return $this->redirectToRoute('app_contrat_lister');
        } else  {
            return $this->render('contrat/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
}