<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;

final class GithubAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private EntityManagerInterface $em,
        private RouterInterface $router,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_github_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('github');
        $accessToken = $this->fetchAccessToken($client);

        /** @var ResourceOwnerInterface $owner */
        $owner = $client->fetchUserFromToken($accessToken);

        $githubId = (string) $owner->getId();
        $identifier = 'github_' . $githubId;

        // Email (optionnel) : GitHub peut ne pas le donner
        $email = null;
        if (method_exists($owner, 'getEmail')) {
            /** @var mixed $maybeEmail */
            $maybeEmail = $owner->getEmail();
            if (is_string($maybeEmail) && trim($maybeEmail) !== '') {
                $email = mb_strtolower(trim($maybeEmail));
            }
        }

        return new SelfValidatingPassport(
            new UserBadge($identifier, function (string $userIdentifier) use ($githubId, $email): SymfonyUserInterface {
                $repo = $this->em->getRepository(User::class);

                /** @var User|null $user */
                $user = null;

                // 1) si email dispo => chercher par email
                if (is_string($email) && $email !== '') {
                    $user = $repo->findOneBy(['email' => $email]);
                }

                // 2) sinon fallback : chercher par email “local” basé sur githubId
                if ($user === null) {
                    $fallbackEmail = 'github_' . $githubId . '@example.local';
                    $user = $repo->findOneBy(['email' => $fallbackEmail]);
                }

                // 3) si toujours pas trouvé => créer
                if ($user === null) {
                    $user = new User();

                    $finalEmail = (is_string($email) && $email !== '')
                        ? $email
                        : ('github_' . $githubId . '@example.local');

                    $user->setEmail($finalEmail);

                    $randomPlain = bin2hex(random_bytes(16));
                    $user->setPassword($this->passwordHasher->hashPassword($user, $randomPlain));

                    $user->setRoles(['ROLE_USER']);
                    $user->setType(User::TYPE_CITIZEN);

                    $this->em->persist($user);
                    $this->em->flush();
                }

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('app_dashboard'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->router->generate('app_login'));
    }
}