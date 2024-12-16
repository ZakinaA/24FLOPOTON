<?php

namespace App\Controller;

use App\Entity\Inscription;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture', name: 'app_facture_')]
class FactureController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_facture_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine, Security $security){
        $repository = $doctrine->getRepository(Inscription::class);
        $entities = $repository->findBy();

        $headers = ['Élève', 'Cours', 'Heure début', 'Jour', 'Prix'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getEleve()?->getPrenom(), 
                $e->getCours()?->getLibelle(),
                $e->getCours()?->getHeureDebut()?->format('H:i'),
                $e->getCours()?->getJour()?->getLibelle(),
                $e->getCours()?->getTypecours()?->getTarif()
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Facture',
            'display' => 'Facture',
            'display_plural' => 'Factures',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }
}
