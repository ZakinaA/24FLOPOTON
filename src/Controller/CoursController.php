<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Cours;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/cours', name: 'app_cours_')]
class CoursController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route('/lister', name: 'lister')]
    public function listerCours(ManagerRegistry $doctrine){
        
        $repository = $doctrine->getRepository(Cours::class);

        $cours= $repository->findAll();
        return $this->render('cours/lister.html.twig', [
            'pCours' => $cours,]);
    }

    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulterCours(ManagerRegistry $doctrine, int $id){

        $cours= $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException(
            'Aucun eleve trouvé avec le numéro '.$id
            );
        }

        //return new Response('Eleve : '.$cours->getLibelle());
        return $this->render('cours/consulter.html.twig', [
            'cours' => $cours,]);
    }
}
