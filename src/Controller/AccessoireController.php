<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Accessoire;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AccessoireType;

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

        $headers = ['Libelle', 'Instrument'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getLibelle(),
                $e->getInstrument()?->getTypeInstrument()?->getLibelle() ?? '',

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

        #[Route('/ajouter', name: 'ajouter')]
        public function ajouter(ManagerRegistry $doctrine, Request $request){
            $e = new Accessoire();
            $form = $this->createForm(AccessoireType::class, $e);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $e = $form->getData();
                
                $entityManager = $doctrine->getManager();
                $entityManager->persist($e);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_accessoire_lister', ['id'=> $e->getId()]);
            }
            
            return $this->render('entities/ajouter.html.twig', [
                'display' => 'Accessoire',
                'form' => $form->createView()
            ]);
        }

        #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove(object: $accessoire); 
        $entityManager->flush();

        return $this->redirectToRoute('app_accessoire_lister');
    }
}