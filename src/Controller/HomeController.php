<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $response = $this->render('home/index.html.twig');
        $response->setPublic();
        $response->setMaxAge(300);
        $response->setSharedMaxAge(300);

        return $response;
    }
}
