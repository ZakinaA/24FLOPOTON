<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ClasseInstrument;
use App\Form\ClasseInstrumentType;
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
        $entities = $repository->findAll();

        $headers = [];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getLibelle(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'ClasseInstrument',
            'display' => 'ClasseInstrument',
            'display_plural' => 'Classes d\'Instruments',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $e = new ClasseInstrument();
        $form = $this->createForm(ClasseInstrumentType::class, $e);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($e);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_classeinstrument_lister', ['id'=> $e->getId()]);
        }
        
        return $this->render('entities/ajouter.html.twig', [
            'display' => 'Classe d\'Instrument',
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $cours = $doctrine->getRepository(ClasseInstrument::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('Aucune classe d\'instrument trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($cours); 
        $entityManager->flush();

        return $this->redirectToRoute('app_classeinstrument_lister');
    }
}
