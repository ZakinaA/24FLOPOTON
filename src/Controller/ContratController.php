<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratModifierType;
use App\Form\ContratType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrat', name: 'app_contrat_')]
class ContratController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_contrat_lister');
    }
    
    #[Route('/lister', name: 'lister')]    
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Contrat::class);
        $entities = $repository->findAll();

        $headers = ['Nom de l\'instrument', 'Prenom de l\'élève', 'Nom de l\'élève', 'Date de début', 'Date de fin', 'État avant le prêt', 'État après le prêt'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getInstrument()?->getTypeInstrument()?->getLibelle(),
                $e->getEleve()?->getPrenom(),
                $e->getEleve()?->getNom(),
                $e->getDateDebut()?->format('d/m/Y'),
                $e->getDateFin()?->format('d/m/Y'), 
                $e->getEtatDetailleDebut(),
                $e->getEtatDetailleFin()
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Contrat',
            'display' => 'Contrat',
            'display_plural' => 'Contrats',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $contrats = new Contrat();
        $form = $this->createForm(ContratType::class, $contrats);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $contrats = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contrats);
            $entityManager->flush();
            
            //return $this->render('contrat/lister.html.twig', ['contrats' => $contrats,]);
            return $this->redirectToRoute('app_contrat_lister');
        } else  {
            return $this->render('entities/ajouter.html.twig', array(
                'display' => 'Contrat',
                'form' => $form->createView(),));
        }
    }
    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifierContrats(ManagerRegistry $doctrine, $id, Request $request){
 
        $contrats = $doctrine->getRepository(Contrat::class)->find($id);
     
        if (!$contrats) {
            throw $this->createNotFoundException('Aucun contrat trouvé avec le numéro '.$id);
        }
        else
        {

                $form = $this->createForm(ContratModifierType::class, $contrats);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $contrats = $form->getData();
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($contrats);
                        $entityManager->flush();
                        //return $this->render('contrat/lister.html.twig', ['contrats' => $contrats,]);
                        return $this->redirectToRoute('app_contrat_lister');
                }
                else
                {
                    return $this->render('entities/modifier.html.twig', array(
                        'display' => 'Contrat',
                        'form' => $form->createView()
                    ));
                }
        }
    }
    #[Route('/supprimer/{id}', name: 'supprimer')]

    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $contrat = $doctrine->getRepository(Contrat::class)->find($id);

        if (!$contrat) {
            throw $this->createNotFoundException('Aucune contrat trouvé avec l\'ID '.$id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($contrat); 
        $entityManager->flush();

        return $this->redirectToRoute('app_contrat_lister');
    }
}