<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Cours;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CoursType;
use App\Form\CoursModifierType;


#[Route('/cours', name: 'app_cours_')]
class CoursController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route('/lister', name: 'lister')]
    public function listerCours(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Cours::class);

        $cours= $repository->findAll();
        return $this->render('cours/lister.html.twig', [
            'pCours' => $cours,]);
    }

    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulterCours(ManagerRegistry $doctrine, int $id){

        $cours= $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException(
            'Aucun cours trouvé avec le numéro '.$id
            );
        }

        //return new Response('Cours : '.$cours->getLibelle());
        return $this->render('cours/consulter.html.twig', [
            'cours' => $cours,]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $cours = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();
            
            return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
        } else  {
            return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    #[Route('/modifier/{id}', name: 'modifier')]

    public function modifierCours(ManagerRegistry $doctrine, $id, Request $request){
 
        //récupération du cours dont l'id est passé en paramètre
        $cours = $doctrine->getRepository(Cours::class)->find($id);
     
        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro '.$id);
        }
        else
        {
                $form = $this->createForm(CoursModifierType::class, $cours);
                $form->handleRequest($request);
     
                if ($form->isSubmitted() && $form->isValid()) {
     
                     $cours = $form->getData();
                     $entityManager = $doctrine->getManager();
                     $entityManager->persist($cours);
                     $entityManager->flush();
                     return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
               }
               else{
                    return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
               }
            }
     }

     #[Route('/supprimer/{id}', name: 'supprimer')]

     public function supprimer(ManagerRegistry $doctrine, int $id): Response
     {
         $cours = $doctrine->getRepository(Cours::class)->find($id);
 
         if (!$cours) {
             throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID '.$id);
         }
 
         $entityManager = $doctrine->getManager();
         $entityManager->remove($cours); 
         $entityManager->flush();
 
         return $this->redirectToRoute('app_cours_lister');
     }

}
