<?php

namespace App\Controller;

use App\Entity\Jour;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/jour', name: 'app_jour_')]
class JourController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('jour/index.html.twig', [
            'controller_name' => 'JourController',
        ]);
    }

    #[Route('/lister', name: 'lister')]
    public function listerJour(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Jour::class);

        $jour= $repository->findAll();
        return $this->render('jour/lister.html.twig', [
            'pJour' => $jour,]);
    }


}