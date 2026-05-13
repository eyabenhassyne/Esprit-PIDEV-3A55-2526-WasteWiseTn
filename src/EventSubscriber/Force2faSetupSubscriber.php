<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Force2faSetupSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private RouterInterface $router
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 8],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $user = $token?->getUser();

        if (!$user instanceof User) {
            return;
        }

        // ✅ seulement citoyen/valorisateur
        if (!in_array($user->getType(), [User::TYPE_CITIZEN, User::TYPE_VALORIZER], true)) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // ✅ éviter les boucles
        $allowedPaths = [
            $this->router->generate('app_2fa_manual'),
            $this->router->generate('2fa_login'),
            '/2fa_check',
            $this->router->generate('app_logout'),
            '/_profiler',
            '/_wdt',
        ];

        foreach ($allowedPaths as $p) {
            if ($p !== '' && str_starts_with($path, $p)) {
                return;
            }
        }

        // ✅ si 2FA pas encore activée => rediriger vers setup
        if (!$user->isTwoFactorEnabled() || !$user->getGoogleAuthenticatorSecret()) {
            $event->setResponse(new RedirectResponse($this->router->generate('app_2fa_manual')));
        }
    }
}