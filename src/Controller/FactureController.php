<?php

namespace App\Controller;

use App\Entity\User;
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
        $entities = $repository->findAll();

        $headers = ['Élève', 'Cours', 'Type de Cours', 'Heure début', 'Jour', 'Prix'];
        $rows = [];

        /** @var User $user */
        $user = $this->getUser();

        if(!$user->getResponsable()){
            throw $this->createNotFoundException('Vous \'êtes pas un responsable d\'élève');
        }

        foreach ($entities as $e) {
            if($e->getEleve()->getResponsable()->getId() == $user->getResponsable()->getId()){
                $rows[] = [
                    $e->getId(),
                    $e->getEleve()?->getPrenom(), 
                    $e->getCours()?->getLibelle(),
                    $e->getCours()?->getTypecours()?->getLibelle(),
                    $e->getCours()?->getHeureDebut()?->format('H:i'),
                    $e->getCours()?->getJour()?->getLibelle(),
                    $e->getCours()?->getTypecours()?->getTarif()?->getMontant()
                ];
            }
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
