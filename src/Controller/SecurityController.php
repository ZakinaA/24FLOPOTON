<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

#[Route('/account', name: 'app_account_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Environment $twig, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->render('security/alreadylogged.html.twig');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $error = false;
            if($form->get('username')->getData() == null || $form->get('password')->getData() == null){
                $this->addFlash('error', 'Informations manquantes');
                $error = true;
            }

            if($userRepository->exist($form->get('username')->getData()) >= 1) {
                $this->addFlash('error', 'Ce nom d\'utilisateur est déjà utilisé');
                $error = true;
            }

            if($error){
                return $this->redirectToRoute('app_account_register', [
                    'form'=>$form,
                ]);
            }

            $username = strtolower($form->get('username')->getData());
            $user->setUsername($username);
            $user->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));

            $responsable = $user->getResponsable();
            if ($responsable && $responsable->getNom() && $responsable->getPrenom()) {
                $em->persist($responsable);
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Votre compte a bien été créé !');
            return $this->redirectToRoute('app_account_login');
        }

        return $this->render('security/register.html.twig', [
            'form'=>$form,
        ]);
    }

    #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('security/edit.html.twig', [
            
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
