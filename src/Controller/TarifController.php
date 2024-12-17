<?php

namespace App\Controller;

use App\Entity\Tarif;
use App\Form\TarifEditType;
use App\Form\TarifType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/tarif', name: 'app_tarif_')]
class TarifController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_tarif_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Tarif::class);
        $entities = $repository->findAll();

        $headers = ['Montant', 'Quotient Familial', 'Type de Cours'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getMontant(),
                $e->getQuotientFamilial()?->getLibelle(),
                $e->getTypeCours()?->getLibelle(),
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Tarif',
            'display' => 'Tarif',
            'display_plural' => 'Tarifs',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulter(ManagerRegistry $doctrine, int $id){
        $repository = $doctrine->getRepository(Tarif::class);
        $e = $repository->find($id);

        if (!$e) {
            throw $this->createNotFoundException('Le Tarif n\'a pas été trouvé');
        }

        $columns = [
            'Montant' => $e->getMontant(),
            'Quotient Familial' => $e->getQuotientFamilial()?->getLibelle(),
            'Type de Cours' => $e->getTypeCours()?->getLibelle()
        ];
 
        return $this->render('entities/consulter.html.twig', [
            'name' => 'Tarif',
            'entity' => $e,
            'columns' => $columns,
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $e = new Tarif();
        $form = $this->createForm(TarifType::class, $e);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($e);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_tarif_consulter', ['id' => $e->getId()]);
        }
        
        return $this->render('entities/ajouter.html.twig', [
            'display' => 'Tarif',
            'form' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(ManagerRegistry $doctrine, $id, Request $request){
        $e = $doctrine->getRepository(Tarif::class)->find($id);
        
        if (!$e) {
            throw $this->createNotFoundException('Aucun tarif trouvé avec l\'ID '.$id);
        }

        $form = $this->createForm(TarifEditType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_tarif_consulter', ['id' => $e->getId()]);
        }

        return $this->render('entities/modifier.html.twig', [
            'display' => 'Tarif',
            'form' => $form->createView()
        ]);
    }
}