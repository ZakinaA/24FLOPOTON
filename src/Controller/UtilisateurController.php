<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Cours;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CoursType;
use App\Form\CoursModifierType;
use App\Form\UserEditType;

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

    #[Route('/consulter/{id<\d+>}', name: 'consulter')]
    public function consulterCours(ManagerRegistry $doctrine, int $id){
        $u = $doctrine->getRepository(User::class)->find($id);

        if (!$u) {
            throw $this->createNotFoundException('Aucun utilisateur trouvé avec le numéro '.$id);
        }

        return $this->render('utilisateur/consulter.html.twig', [
            'u' => $u
        ]);
    }
    
    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(ManagerRegistry $doctrine, $id, Request $request, UserPasswordHasherInterface $hasher){
        $u = $doctrine->getRepository(User::class)->find($id);
     
        if (!$u) {
            throw $this->createNotFoundException('Aucun utilisateur trouvé avec l\'ID '.$id);
        }

        $form = $this->createForm(UserEditType::class, $u, [
            'user' => $u,
            'responsable' => $u->getResponsable(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            if ($form->get('responsable')->getData()) {
                $responsable = $form->get('responsable')->getData();
                $entityManager->persist($responsable);
                $u->setResponsable($responsable);
            }

            //if ($form->get('password')->getData() && $form->get('password')->getData() != null) {
            //    $u->setPassword($hasher->hashPassword($u, $form->get('password')->getData()));
            //}

            $entityManager->flush();
            return $this->redirectToRoute('app_utilisateur_consulter', ['id' => $id]);
        }

        return $this->render('utilisateur/modifier.html.twig', ['form' => $form->createView()]);
    }
}
