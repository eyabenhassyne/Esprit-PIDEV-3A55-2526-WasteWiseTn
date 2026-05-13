<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\FacebookUser;
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

final class FacebookAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private EntityManagerInterface $em,
        private RouterInterface $router,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_facebook_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('facebook');
        $accessToken = $this->fetchAccessToken($client);

        /** @var FacebookUser $fbUser */
        $fbUser = $client->fetchUserFromToken($accessToken);

        $email = $fbUser->getEmail();
        if (!is_string($email) || trim($email) === '') {
            throw new AuthenticationException(
                "Facebook ne fournit pas l'email. Vérifie les permissions (scope: email)."
            );
        }

        $email = mb_strtolower(trim($email));

        return new SelfValidatingPassport(
            new UserBadge($email, function (string $userIdentifier) use ($fbUser): SymfonyUserInterface {
                /** @var User|null $user */
                $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userIdentifier]);

                if ($user === null) {
                    $user = new User();
                    $user->setEmail($userIdentifier);

                    // ✅ PHPStan: pas de ?? ici (getName() est typé string)
                    $fullName = trim((string) $fbUser->getName());

                    if ($fullName !== '') {
                        $parts = preg_split('/\s+/', $fullName) ?: [];
                        $prenom = $parts[0] ?? '';
                        $nom = $parts[1] ?? '';

                        $user->setPrenom($prenom !== '' ? $prenom : 'User');
                        $user->setNom($nom !== '' ? $nom : 'Facebook');
                    } else {
                        $user->setPrenom('User');
                        $user->setNom('Facebook');
                    }

                    $randomPlain = bin2hex(random_bytes(16));
                    $user->setPassword($this->passwordHasher->hashPassword($user, $randomPlain));

                    $user->setRoles([]);
                    $user->setType(User::TYPE_CITIZEN);

                    $this->em->persist($user);
                    $this->em->flush();
                } else {
                    // ✅ PHPStan: on évite ?? dans trim()
                    $nom = $user->getNom();
                    if ($nom === null || trim($nom) === '') {
                        $user->setNom('Facebook');
                    }

                    $prenom = $user->getPrenom();
                    if ($prenom === null || trim($prenom) === '') {
                        $user->setPrenom('User');
                    }

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