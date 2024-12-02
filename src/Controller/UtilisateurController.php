<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Cours;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CoursType;
use App\Form\CoursModifierType;


#[Route('/utilisateur', name: 'app_utilisateur_')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_utilisateur_lister');
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(User::class);

        $users= $repository->findAll();
        return $this->render('utilisateur/lister.html.twig', [
            'users' => $users
        ]);
    }
}
