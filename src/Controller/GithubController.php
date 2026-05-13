<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GithubController extends AbstractController
{
    #[Route('/connect/github', name: 'connect_github_start')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        // on demande l’email même si privé
        return $clientRegistry->getClient('github')->redirect(
            ['user:email'],
            [
                // GitHub ignore parfois approval_prompt, on évite.
                // On force juste un paramètre standard si besoin :
                // 'allow_signup' => 'true',
            ]
        );
    }

    #[Route('/connect/github/check', name: 'connect_github_check')]
    public function check(): void
    {
       
    }
}
