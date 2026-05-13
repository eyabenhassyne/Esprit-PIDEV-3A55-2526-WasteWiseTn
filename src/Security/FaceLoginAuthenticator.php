<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class FaceLoginAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        // ✅ IMPORTANT : ne jamais s'exécuter automatiquement
        return false;
    }

    public function authenticate(Request $request): Passport
    {
        // ✅ jamais appelé car supports() = false, mais la signature doit être valide
        return new SelfValidatingPassport(new UserBadge('unused'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
