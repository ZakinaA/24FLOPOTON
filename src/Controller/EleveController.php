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
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Eleve::class);
        $entities = $repository->findAll();

        $headers = ['Nom', 'Prenom', 'Ville', 'Téléphone', 'Mail', 'Nom du responsable', 'Prenom du responsable'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getNom(),
                $e->getPrenom(),
                $e->getVille(),
                $e->getTel(),
                $e->getMail(),
                $e->getResponsable()->getNom(),
                $e->getResponsable()->getPrenom(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Eleve',
            'display' => 'Eleve',
            'display_plural' => 'Eleves',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }
    #[Route('/consulter/{id}', name: 'consulter')]    
    public function consulter(ManagerRegistry $doctrine, int $id){
        $repository = $doctrine->getRepository(Eleve::class);
        $entity = $repository->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Le Cours n\'a pas été trouvé');
        }

        $coursLibelles = [];
        foreach ($entity->getInscriptions() as $inscription) {
            $coursLibelles[] = $inscription->getCours()?->getLibelle();
        }

        $columns = [
            'Identifiant' => $entity->getId(),
            'Nom' => $entity->getNom(),
            'Preom' => $entity->getPrenom(),
            'Cours' => $coursLibelles,
            'Ville' => $entity->getVille(),
            'Code Postal' => $entity->getCopos(),
            'Numéro de rue' => $entity->getNumRue(),
            'Rue' => $entity->getRue(),
            'Responsable ' => $entity->getResponsable()?->getPrenom().' - '.$entity->getResponsable()?->getNom(),
            'Ville du responsable' => $entity->getResponsable()?->getVille(),
            'Code Postal du responsable' => $entity->getResponsable()?->getCopos(),
            'Numéro de rue du responsable' => $entity->getResponsable()?->getNumRue(),
            'Rue du responsable' => $entity->getResponsable()?->getRue(),


            
        ];

        //return new Response('Eleves : '.$eleves->getLibelle());
        return $this->render('entities/consulter.html.twig', [
            'name' => 'Eleve',
            'entity' => $entity,
            'columns' => $columns,
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
            return $this->render('entities/ajouter.html.twig', array(
                'display' => 'Eleve',
                'form' => $form->createView(),));
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
                    return $this->render('entities/modifier.html.twig', array(
                        'display' => 'Eleve',
                        'form' => $form->createView(),));
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
