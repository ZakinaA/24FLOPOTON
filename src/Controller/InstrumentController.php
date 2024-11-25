<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Instrument;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/instrument', name: 'instrument')]
class InstrumentController extends AbstractController
{
    #[Route('/index', name: 'index')]
    function accueil(): Response
    {
        $annee = '2024';
        return $this->render('instrument/index.html.twig', ['pAnnee' => $annee,
       ]);	
    }

    #[Route('/lister', name: 'lister')]
    function instrumentLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Instrument::class);

    $instruments= $repository->findAll();
    return $this->render('instrument/lister.html.twig', [
        'iInstrument' => $instruments,]);
    }
}