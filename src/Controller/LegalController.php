<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/privacy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('legal/privacy.html.twig');
    }

    #[Route('/data-deletion', name: 'app_data_deletion')]
    public function dataDeletion(): Response
    {
        return $this->render('legal/data_deletion.html.twig');
    }
}
