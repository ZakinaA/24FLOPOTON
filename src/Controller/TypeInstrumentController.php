<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\TypeInstrument;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/typeinstrument', name: 'app_typeinstrument_')]
class TypeInstrumentController extends AbstractController
{
    #[Route('/index', name: 'index')]
    function accueil(): Response
    {
        $annee = '2024';
        return $this->render('type_instrument/accueil.html.twig', ['pAnnee' => $annee,
       ]);	
    }

    #[Route('/lister', name: 'lister')]
    function typeinstrumentLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(TypeInstrument::class);

    $typesinstruments= $repository->findAll();
    return $this->render('type_instrument/lister.html.twig', [
        'tTypesInstruments' => $typesinstruments,]);
    }
}
