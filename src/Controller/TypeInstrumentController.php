<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\TypeInstrument;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/typeinstrument', name: 'app_typeinstrument_')]
class TypeInstrumentController extends AbstractController
{
    #[Route('/', name: 'index')]
    function index(): Response
    {
        return $this->redirectToRoute('app_typeinstrument_lister');
    }

    #[Route('/lister', name: 'lister')]
    function typeinstrumentLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(TypeInstrument::class);

    $typesinstruments= $repository->findAll();
    return $this->render('type_instrument/lister.html.twig', [
        'tTypesInstruments' => $typesinstruments,]);
    }
   
    #[Route('/consulter/{id}', name: 'consulter')]
    public function consultertypeInstrument(ManagerRegistry $doctrine, int $id){
        $typeinstrument= $doctrine->getRepository(TypeInstrument::class)->find($id);

        if (!$typeinstrument) {
            throw $this->createNotFoundException(
            'Aucun instrument trouvé avec le numéro '.$id
            );
        }

        //return new Response('Instrument : '.$instruments->getLibelle());
        return $this->render('type_instrument/consulter.html.twig', [
            'typeinstrument' => $typeinstrument,
        ]);
    }
}
