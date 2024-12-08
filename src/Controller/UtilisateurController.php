<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserEditType;

#[Route('/utilisateur', name: 'app_utilisateur_')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_utilisateur_lister');
    }

    #[Route('/listerold', name: 'listerold')]
    public function listerold(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(User::class);

        $users= $repository->findAll();
        return $this->render('utilisateur/lister.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/lister', name: 'lister')]
    public function lister(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(User::class);
        $entities = $repository->findAll();

        $headers = ['Nom d\'utilisateur', 'Rôles', 'Responsable'];
        $rows = [];

        foreach ($entities as $e) {
            $rows[] = [
                $e->getId(),
                $e->getUsername(),
                $e->getRoles(),
                $e->getResponsable() ? 'Oui' : 'Non',
                //$e->getCategory() ? $entity->getCategory()->getName() : 'Aucune',
            ];
        }

        return $this->render('entities/lister.html.twig', [
            'name' => 'Utilisateur',
            'diplay' => 'Utilisateur',
            'diplay_plural' => 'Utilisateurs',
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    #[Route('/consulterold/{id<\d+>}', name: 'consulterold')]
    public function consulter(ManagerRegistry $doctrine, int $id){
        $u = $doctrine->getRepository(User::class)->find($id);

        if (!$u) {
            throw $this->createNotFoundException('Aucun utilisateur trouvé avec le numéro '.$id);
        }

        return $this->render('utilisateur/consulter.html.twig', [
            'u' => $u
        ]);
    }

    #[Route('/consulter/{id<\d+>}', name: 'consulter')]
    public function consulter2(ManagerRegistry $doctrine, int $id){
        $repository = $doctrine->getRepository(User::class); // Remplace User par l'entité concernée
        $entity = $repository->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('L\'utilisateur n\'a pas été trouvé');
        }

        $columns = [
            'Nom d\'utilisateur' => $entity->getUsername(),
            'Rôles' => $entity->getRoles(),
            'Responsable' => $entity->getResponsable() ? 'Oui' : 'Non',
        ];

        return $this->render('entities/consulter.html.twig', [
            'name' => 'Utilisateur',
            'entity' => $entity,
            'columns' => $columns,
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
