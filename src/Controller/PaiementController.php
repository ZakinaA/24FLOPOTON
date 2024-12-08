<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Paiement;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/paiement', name: 'app_paiement_')]
class PaiementController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_paiement_lister');
    }
    
    #[Route('/lister', name: 'lister')]
    public function listerPaiement(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Paiement::class);

        $paiement= $repository->findAll();
        return $this->render('paiement/lister.html.twig', [
            'pPaiement' => $paiement,]);
    }

}
