<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login'); // ou app_register
    }

    #[Route('/home', name: 'app_root')]
    public function root(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
