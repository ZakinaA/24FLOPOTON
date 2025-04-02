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
use App\Repository\CoursRepository;
use App\Entity\Eleve;




#[Route('/cours', name: 'app_cours_')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_cours_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Cours::class);
        $entities = $repository->findAll();

        $headers = ['Libelle', 'Âge minimum', 'Heure début', 'Heure fin', 'Jour', 'Professeur', 'Type'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getLibelle(),
                $e->getAgeMini(),
                $e->getHeureDebut()->format('H:i'),
                $e->getHeureFin()->format('H:i'),
                $e->getJour()?->getLibelle() ?? '',
                $e->getProfesseur()?->getPrenom().' '.$e->getProfesseur()?->getPrenom(),
                $e->getTypecours()?->getLibelle() ?? '',
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Cours',
            'display' => 'Cours',
            'display_plural' => 'Cours',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulter(ManagerRegistry $doctrine, int $id){
        $repository = $doctrine->getRepository(Cours::class);
        $entity = $repository->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Le Cours n\'a pas été trouvé');
        }

        $columns = [
            'Libelle' => $entity->getLibelle(),
            'Age Minimum' => $entity->getAgeMini(),
            'Heure de début' => $entity->getHeureDebut()->format('H:i'),
            'Heure de Fin' => $entity->getHeureFin()->format('H:i'),
            'Jour' => $entity->getJour()?->getLibelle(),
            'Professeur' => $entity->getProfesseur()?->getPrenom().' '.$entity->getProfesseur()?->getNom(),
            'Type Cours' => $entity->getTypeCours()?->getLibelle(),
        ];
 
        return $this->render('entities/consulter.html.twig', [
            'name' => 'Cours',
            'entity' => $entity,
            'columns' => $columns,
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $e = new Cours();
        $form = $this->createForm(CoursType::class, $e);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($e);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_cours_consulter', ['id'=> $e->getId()]);
        }
        
        return $this->render('entities/ajouter.html.twig', [
            'display' => 'Cours',
            'form' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(ManagerRegistry $doctrine, $id, Request $request){
        $e = $doctrine->getRepository(Cours::class)->find($id);
        
        if (!$e) {
            throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID '.$id);
        }

        $form = $this->createForm(CoursModifierType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_cours_consulter', ['id'=> $e->getId()]);
        }

        return $this->render('entities/modifier.html.twig', [
            'display' => 'Cours',
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]

    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $cours = $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('Aucune cours trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($cours); 
        $entityManager->flush();

        return $this->redirectToRoute('app_cours_lister');
    }
}