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
        return $this->redirectToRoute('app_login');
    }

    #[Route('/home', name: 'app_root')]
    public function root(): Response
    {
        $response = $this->render('home/index.html.twig');
        $response->setPublic();
        $response->setMaxAge(300);
        $response->setSharedMaxAge(300);

        return $response;
    }
}
