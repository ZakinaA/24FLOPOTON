<?php

namespace App\Controller;

use App\Entity\QuotientFamilial;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quotientfamilial', name: 'app_quotientfamilial_')]
class QuotientFamilialController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_quotientfamilial_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(QuotientFamilial::class);

        $quotients= $repository->findAll();
        return $this->render('quotient_familial/lister.html.twig', [
            'quotients' => $quotients
        ]);
    }
}
