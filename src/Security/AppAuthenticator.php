<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function authenticate(Request $request): Passport
    {
        // 👉 utilisé seulement pour login password
        $email = (string) $request->request->get('email', '');
        $request->getSession()->set('_security.last_username', $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials((string) $request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', (string) $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    /**
     * ✅ Redirection intelligente après login
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
    {
        $user = $token->getUser();

        if ($user instanceof User) {
            $route = match ($user->getType()) {
                User::TYPE_ADMIN => 'app_dashboard_admin',
                User::TYPE_VALORIZER => 'app_dashboard_valorizateur',
                default => 'app_dashboard_citoyen',
            };

            return new RedirectResponse($this->urlGenerator->generate($route));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_dashboard'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
