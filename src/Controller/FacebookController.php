<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    #[Route('/connect/facebook', name: 'connect_facebook_start')]
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        // scopes possibles : ['email'] (souvent suffisant)
        return $clientRegistry
            ->getClient('facebook')
            ->redirect(['email'], []);
    }

    #[Route('/connect/facebook/check', name: 'connect_facebook_check')]
    public function connectCheckAction(): void
    {
        // Symfony intercepte automatiquement cette route (ne rien mettre ici)
    }
}
