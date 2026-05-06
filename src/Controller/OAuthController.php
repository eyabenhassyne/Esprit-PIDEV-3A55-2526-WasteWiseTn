<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OAuthController extends AbstractController
{
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connectGoogle(ClientRegistry $clientRegistry): RedirectResponse
    {
        // ✅ Force Google à afficher l'écran "Choisir un compte"
        return $clientRegistry
            ->getClient('google')
            ->redirect(
                ['email', 'profile'],
                [
                    'prompt' => $this->getParameter('google.oauth_prompt'), // 'select_account'
                ]
            );
    }

    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectGoogleCheck(): Response
    {
        // ✅ Cette route est gérée par l’Authenticator (ne rien mettre ici)
        return new Response('Google check.');
    }

    #[Route('/connect/facebook/check', name: 'connect_facebook_check')]
    public function connectFacebookCheck(): Response
    {
        return new Response('Facebook check.');
    }
}