<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Instrument;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\InstrumentType;


#[Route('/instrument', name: 'app_instrument_')]
class InstrumentController extends AbstractController
{
    #[Route('/index', name: 'index')]
    function accueil(): Response
    {
        $annee = '2024';
        return $this->render('instrument/index.html.twig', ['pAnnee' => $annee,
       ]);	
    }

    #[Route('/lister', name: 'lister')]
    function instrumentLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Instrument::class);

    $instruments= $repository->findAll();
    return $this->render('instrument/lister.html.twig', [
        'iInstrument' => $instruments,]);
    }

    #[Route('/consulter/{id}', name: 'consulter')]
    public function consulterInstrument(ManagerRegistry $doctrine, int $id){

        $instrument= $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException(
            'Aucun instrument trouvé avec le numéro '.$id
            );
        }

        $intervention = $instrument->getInterventions();
        //return new Response('Instrument : '.$instruments->getLibelle());
        return $this->render('instrument/consulter.html.twig', [
            'instrument' => $instrument,
            'intervention' => $intervention
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request){
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $instrument = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_instrument_consulter', ['id' => $instrument->getId()]);
        } else  {
            return $this->render('instrument/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
}