<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveModifierType;
use App\Form\EleveType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/eleve', name: 'app_eleve_')]

class EleveController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_eleve_lister');
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
    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulterEleves(ManagerRegistry $doctrine, int $id){

        $eleve= $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException(
            'Aucun eleves trouvé avec le numéro '.$id
            );
        }

        //return new Response('Eleves : '.$eleves->getLibelle());
        return $this->render('eleve/consulter.html.twig', [
            'eleve' => $eleve,]);
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
    #[Route('/modifier/{id}', name: 'modifier')]

    public function modifierEleves(ManagerRegistry $doctrine, $id, Request $request){
 
        $eleves = $doctrine->getRepository(Eleve::class)->find($id);
     
        if (!$eleves) {
            throw $this->createNotFoundException('Aucun eleves trouvé avec le numéro '.$id);
        }
        else
        {
                $form = $this->createForm(EleveModifierType::class, $eleves);
                $form->handleRequest($request);
     
                if ($form->isSubmitted() && $form->isValid()) {
     
                     $eleves = $form->getData();
                     $entityManager = $doctrine->getManager();
                     $entityManager->persist($eleves);
                     $entityManager->flush();
                     //return $this->render('eleve/lister.html.twig', ['eleves' => $eleves,]);
                     return $this->redirectToRoute('app_eleve_lister');
               }
               else{
                    return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
               }
            }
     }
     #[Route('/supprimer/{id}', name: 'supprimer')]

    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucune eleve trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($eleve); 
        $entityManager->flush();

        return $this->redirectToRoute('app_eleve_lister');
    }
}
