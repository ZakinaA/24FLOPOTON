<?php

namespace App\Controller;

use App\Entity\QuotientFamilial;
use App\Form\QuotientFamilialEditType;
use App\Form\QuotientFamilialType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/ajouter', name:'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $q = new QuotientFamilial();
        $form = $this->createForm(QuotientFamilialType::class, $q);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $q = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($q);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_quotientfamilial_lister');
        }
        
        return $this->render('quotient_familial/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(ManagerRegistry $doctrine, $id, Request $request){
        $q = $doctrine->getRepository(QuotientFamilial::class)->find($id);
     
        if (!$q) {
            throw $this->createNotFoundException('Aucun quotient familial trouvé avec l\'ID '.$id);
        }

        $form = $this->createForm(QuotientFamilialEditType::class, $q);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_quotientfamilial_lister');
        }

        return $this->render('quotient_familial/modifier.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
     public function supprimer(ManagerRegistry $doctrine, int $id): Response
     {
        $q = $doctrine->getRepository(QuotientFamilial::class)->find($id);

        if (!$q) {
            throw $this->createNotFoundException('Aucun quotient familial trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($q); 
        $entityManager->flush();

        return $this->redirectToRoute('app_quotientfamilial_lister');
     }
}
