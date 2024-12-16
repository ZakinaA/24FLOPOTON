<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Paiement;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PaiementType;
use App\Form\PaiementModifierType;

#[Route('/paiement', name: 'app_paiement_')]
class PaiementController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_paiement_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Paiement::class);
        $entities = $repository->findAll();

        $headers = ['Nom du cours', 'Nom de l\'Eleve', 'Montant du Paiement', 'Date du Paiement', 'Type'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getInscription()?->getCours()?->getLibelle(),
                $e->getInscription()?->getEleve()?->getPrenom().' '.$e->getInscription()?->getEleve()?->getNom(),
                $e->getMontant(),
                $e->getDatePaiement()->format('m/d/Y')
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Paiement',
            'display' => 'Paiement',
            'display_plural' => 'Paiements',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }
    
    #[Route('/listerold', name: 'listerold')]
    public function listerPaiement(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Paiement::class);

        $paiement= $repository->findAll();
        return $this->render('paiement/lister.html.twig', [
            'pPaiement' => $paiement,]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $paiement = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($paiement);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_paiement_lister');
        } else  {
            return $this->render('entities/ajouter.html.twig', [
                'display' => 'Paiement',
                'form' => $form->createView()
        ]);
        }
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifierPaiement(ManagerRegistry $doctrine, $id, Request $request){
 
        //récupération du cours dont l'id est passé en paramètre
        $paiement = $doctrine->getRepository(Paiement::class)->find($id);
     
        if (!$paiement) {
            throw $this->createNotFoundException('Aucun paiement trouvé avec le numéro '.$id);
        }
        
        $form = $this->createForm(PaiementModifierType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $paiement = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($paiement);
                $entityManager->flush();
                return $this->redirectToRoute('app_paiement_lister');
        }
        else{
            return $this->render('entities/ajouter.html.twig', [
                'display' => 'Paiement',
                'form' => $form->createView()
            ]);
        }  
     }

     #[Route('/supprimer/{id}', name: 'supprimer')]
     public function supprimer(ManagerRegistry $doctrine, int $id): Response
     {
         $paiement = $doctrine->getRepository(Paiement::class)->find($id);
 
         if (!$paiement) {
             throw $this->createNotFoundException('Aucun paiement trouvé avec l\'ID '.$id);
         }
 
         $entityManager = $doctrine->getManager();
         $entityManager->remove($paiement); 
         $entityManager->flush();
 
         return $this->redirectToRoute('app_paiement_lister');
     }
}
