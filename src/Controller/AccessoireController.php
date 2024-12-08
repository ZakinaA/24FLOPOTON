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
    function accessoireLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Accessoire::class);

    $accessoires= $repository->findAll();
    return $this->render('accessoire/lister.html.twig', [
        'aAccessoires' => $accessoires,]);
    }
}