<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Inscription;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CoursType;
use App\Form\CoursModifierType;

#[Route(path: '/inscription', name: 'app_inscription_')]

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    
    #[Route('/lister', name: 'lister')]
    public function listerInscription(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Inscription::class);

        $inscription= $repository->findAll();
        return $this->render('inscription/lister.html.twig', [
            'pInscription' => $inscription,]);
    }
}
