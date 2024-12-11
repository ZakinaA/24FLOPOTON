<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Inscription;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\InscriptionType;
use App\Form\InscriptionModifierType;

#[Route(path: '/inscription', name: 'app_inscription_')]

class InscriptionController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_inscription_lister');
    }
    
    #[Route('/lister', name: 'lister')]
    public function listerInscription(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Inscription::class);

        $inscription= $repository->findAll();
        return $this->render('inscription/lister.html.twig', [
            'pInscription' => $inscription,]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_inscription_lister');
        } else  {
            return $this->render('inscription/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
    
    #[Route('/modifier/{id}', name: 'modifier')]

    public function modifierInscription(ManagerRegistry $doctrine, $id, Request $request){
 

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);
     
        if (!$inscription) {
            throw $this->createNotFoundException('Aucune inscription trouvé avec le numéro '.$id);
        }
        else
        {
                $form = $this->createForm(InscriptionModifierType::class, $inscription);
                $form->handleRequest($request);
     
                if ($form->isSubmitted() && $form->isValid()) {
     
                     $inscription = $form->getData();
                     $entityManager = $doctrine->getManager();
                     $entityManager->persist($inscription);
                     $entityManager->flush();
                     return $this->redirectToRoute('app_inscription_lister');
               }
               else{
                    return $this->render('inscription/ajouter.html.twig', array('form' => $form->createView(),));
               }
            }
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]

    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($inscription); 
        $entityManager->flush();

        return $this->redirectToRoute('app_inscription_lister');
    }
}
