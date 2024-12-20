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




#[Route('/calendrier', name: 'app_calendrier_')]
class CalendrierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function calendrier(CoursRepository $coursRepository): Response
    {
        // Récupération de tous les cours
        $coursList = $coursRepository->findAll();

        // Liste des jours et des heures
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $heures = range(8, 18); // De 8h à 18h

        return $this->render('cours/calendrier.html.twig', [
            'coursList' => $coursList,
            'jours' => $jours,
            'heures' => $heures,
        ]);
    }

    #[Route('/eleve/{eleveId}', name: 'eleve')]
    // CoursController.php
    public function calendrierEleve(int $eleveId, CoursRepository $coursRepository, ManagerRegistry $doctrine): Response
    {
        // Récupérer l'élève via son ID
        $eleve = $doctrine->getRepository(Eleve::class)->find($eleveId);

        if (!$eleve) {
            throw $this->createNotFoundException('L\'élève n\'a pas été trouvé');
        }

        //if ($eleve->getResponsable()->getId() !== $this->getUser()->getResponsable()->getId()) {
        //    throw $this->createNotFoundException('L\'élève n\'a pas été trouvé');
        //}

        // Récupérer les cours auxquels l'élève est inscrit
        $coursList = $coursRepository->findByEleve($eleve);

        // Définir la liste des jours de la semaine
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

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