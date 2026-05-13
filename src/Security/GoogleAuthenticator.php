<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class GoogleAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private EntityManagerInterface $em,
        private RouterInterface $router,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        $accessToken = $this->fetchAccessToken($client);

        /** @var GoogleUser $googleUser */
        $googleUser = $client->fetchUserFromToken($accessToken);

        $email = $googleUser->getEmail();
        if (!is_string($email) || trim($email) === '') {
            throw new AuthenticationException("Google ne fournit pas l'email.");
        }

        $email = mb_strtolower(trim($email));

        return new SelfValidatingPassport(
            new UserBadge($email, function (string $userIdentifier): SymfonyUserInterface {
                /** @var User|null $user */
                $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userIdentifier]);

                if ($user === null) {
                    $user = new User();
                    $user->setEmail($userIdentifier);

                    // mot de passe aléatoire (exigé par PasswordAuthenticatedUserInterface)
                    $randomPlain = bin2hex(random_bytes(16));
                    $user->setPassword($this->passwordHasher->hashPassword($user, $randomPlain));

                    // rôle de base (getRoles() ajoutera aussi ROLE_ADMIN/ROLE_VALORIZER selon type)
                    $user->setRoles(['ROLE_USER']);

                    // type explicite (ton User possède setType)
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