<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Accessoire;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/accessoire', name: 'app_accessoire_')]
class AccessoireController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_accessoire_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Accessoire::class);
        $entities = $repository->findAll();

        $headers = ['Libelle'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getLibelle(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Accessoire',
            'display' => 'Accessoire',
            'display_plural' => 'Accessoires',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/listerold', name: 'listerold')]
    function accessoireLister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Accessoire::class);
        $accessoires= $repository->findAll();

        return $this->render('accessoire/lister.html.twig', [
            'aAccessoires' => $accessoires,]);
        }
}