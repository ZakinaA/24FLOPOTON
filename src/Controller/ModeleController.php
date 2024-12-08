<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Modele;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/modele', name: 'app_modele_')]
class ModeleController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_modele_lister');
    }

    #[Route('/lister', name: 'lister')]
    function modeleLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Modele::class);

    $modeles= $repository->findAll();
    return $this->render('modele/lister.html.twig', [
        'mModele' => $modeles,]);
    }
}