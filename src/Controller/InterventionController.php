<?php

namespace App\Controller;

use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\InterventionType;
use App\Form\InterventionEditType;



#[Route('/intervention', name: 'app_intervention_')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_intervention_lister');
    }
    
    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Intervention::class);
        $entities = $repository->findAll();

        $headers = ['Nom du professtionnel', 'Nom de l\'instrument', 'Date de début', 'Date de fin', 'Descriptif', 'Prix', 'quotité'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getProfessionnel()->getNom(),
                $e->getInstrument()?->getTypeInstrument()?->getLibelle(),
                $e->getDateDebut()->format('d/m/Y'),
                $e->getDateFin()->format('d/m/Y'),
                $e->getDescriptif(),
                $e->getPrix(),
                $e->getQuotite(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Intervention',
            'display' => 'Intervention',
            'display_plural' => 'Interventions',
            'headers' => $headers,
            'rows' => $rows,
        ]); 
    }
    
    #[Route('/ajouter', name:'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $intervention = new intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $intervention = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_intervention_lister');
        } else  {
            return $this->render('entities/ajouter.html.twig', array(
                'display' => 'intervention',
                'form' => $form->createView(),));
        }
    }
    #[Route('/modifier/{id}', name:'modifier', methods:['GET', 'POST'])]
    public function modifierContrats(ManagerRegistry $doctrine, $id, Request $request){
 
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);
     
        if (!$intervention) {
            throw $this->createNotFoundException('Aucune Intervention trouvée avec le numéro '.$id);
        }
        else
        {

                $form = $this->createForm(InterventionEditType::class, $intervention);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $intervention = $form->getData();
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($intervention);
                        $entityManager->flush();
                        return $this->redirectToRoute('app_intervention_lister');
                }
                else
                {
                    return $this->render('entities/modifier.html.twig', array(
                        'display' => 'intervention',
                        'form' => $form->createView()
                    ));
                }
        }
    }
    #[Route('/supprimer/{id}', name: 'supprimer')]

    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('Aucune intervention trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($intervention); 
        $entityManager->flush();

        return $this->redirectToRoute('app_intervention_lister');
    }

}
