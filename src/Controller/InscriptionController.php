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
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Inscription::class);
        $entities = $repository->findAll();

        $headers = ['Nom du Cours', 'Nom de l\'Eleve', 'Date de l\'Inscription'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getCours()?->getLibelle(),
                $e->getEleve()?->getNom(),
                $e->getDateInscription()?->format('d/m/Y'),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Inscription',
            'display' => 'Inscription',
            'display_plural' => 'Inscriptions',
            'headers' => $headers,
            'rows' => $rows,
        ]);
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
            return $this->render('entities/ajouter.html.twig', array(
                'display' => 'Inscription',
                'form' => $form->createView(),));
        }
    }
    
    #[Route('/modifier/{id}', name: 'modifier')]

    public function modifierInscription(ManagerRegistry $doctrine, $id, Request $request){
 

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);
     
        if (!$inscription) {
            throw $this->createNotFoundException('Aucune inscription trouvée avec le numéro '.$id);
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
               else
               {
                    return $this->render('entities/modifier.html.twig', array(
                        'display' => 'Inscription',
                        'form' => $form->createView()
                    ));
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
