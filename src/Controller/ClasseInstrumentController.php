<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ClasseInstrument;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/classeinstrument', name: 'app_classeinstrument_')]
class ClasseInstrumentController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_classeinstrument_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(ClasseInstrument::class);

        $classesinstruments= $repository->findAll();
        return $this->render('classe_instrument/lister.html.twig', [
            'cClasseInstrument' => $classesinstruments
        ]);
    }
}
