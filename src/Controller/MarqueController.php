<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Marque;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/marque', name: 'app_marque_')]
class MarqueController extends AbstractController
{
    #[Route('/index', name: 'index')]
    function accueil(): Response
    {
        $annee = '2024';
        return $this->render('marque/index.html.twig', ['pAnnee' => $annee,
       ]);	
    }

    #[Route('/lister', name: 'lister')]
    function marqueLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Marque::class);

    $marques= $repository->findAll();
    return $this->render('marque/lister.html.twig', [
        'mMarque' => $marques,]);
    }
}