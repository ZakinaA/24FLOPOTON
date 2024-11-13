<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\TypeInstrument;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/typeinstrument', name: 'typeinstrument_')]
class TypeInstrumentController extends AbstractController
{
    #[Route('/index', name: 'index')]
    function accueil(): Response
    {
        $annee = '2024';
        return $this->render('etudiant/accueil.html.twig', ['pAnnee' => $annee,
       ]);	
    }

    #[Route('/lister', name: 'lister')]
    function etudiantLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Etudiant::class);

    $typesinstruments= $repository->findAll();
    return $this->render('typeinstrument/lister.html.twig', [
        'tTypeInstrument' => $typesinstruments,]);
    }
}
