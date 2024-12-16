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
            throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($cours); 
        $entityManager->flush();

        return $this->redirectToRoute('app_cours_lister');
    }

    #[Route('/calendrier', name: 'calendrier')]
public function calendrier(CoursRepository $coursRepository): Response
{
    // Récupération de tous les cours
    $coursList = $coursRepository->findAll();

    // Liste des jours et des heures
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $heures = range(8, 18); // De 8h à 18h

    return $this->render('cours/calendrier.html.twig', [
        'coursList' => $coursList,
        'jours' => $jours,
        'heures' => $heures,
    ]);
}

#[Route('/calendrier/eleve/{eleveId}', name: 'calendrier_eleve')]
// CoursController.php
public function calendrierEleve(int $eleveId, CoursRepository $coursRepository, ManagerRegistry $doctrine): Response
{
    // Récupérer l'élève via son ID
    $eleve = $doctrine->getRepository(Eleve::class)->find($eleveId);

    if (!$eleve) {
        throw $this->createNotFoundException('L\'élève n\'a pas été trouvé');
    }

    // Récupérer les cours auxquels l'élève est inscrit
    $coursList = $coursRepository->findByEleve($eleve);

    // Définir la liste des jours de la semaine
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    // Définir la liste des heures, de 8h à 18h
    $heures = range(8, 18);  // Exemple pour 8h à 18h

    // Passer les données au template
    return $this->render('cours/calendrier_eleve.html.twig', [
        'coursList' => $coursList,  // Liste des cours de l'élève
        'eleve' => $eleve,
        'jours' => $jours,  // Liste des jours de la semaine
        'heures' => $heures,  // Liste des heures de début
    ]);
}




}