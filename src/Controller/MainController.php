<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/gestionnaire', name: 'gestionnaire')]
    public function gestionnaire(): Response
    {
        return $this->render('main/gestionnaire.html.twig');
    }

    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('main/admin.html.twig');
    }
}
