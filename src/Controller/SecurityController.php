<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/face-login', name: 'app_face_login', methods: ['GET'])]
    public function faceLoginPage(Request $request): Response
    {
        // ✅ créer session dès la page (cookie PHPSESSID)
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        return $this->render('auth/face_login.html.twig');
    }

    private function dashboardRouteFor(User $user): string
    {
        return match ($user->getType()) {
            User::TYPE_ADMIN => 'app_dashboard_admin',
            User::TYPE_VALORIZER => 'app_dashboard_valorizateur',
            default => 'app_dashboard_citoyen',
        };
    }

    #[Route('/api/face-login/verify', name: 'api_face_login_verify', methods: ['POST'])]
    public function verifyFace(
        Request $request,
        UserRepository $users,
        FaceService $faceService,
        TokenStorageInterface $tokenStorage,
        SessionAuthenticationStrategyInterface $sessionStrategy
    ): JsonResponse {
        $payload = json_decode($request->getContent(), true);
        if (!is_array($payload)) {
            $payload = [];
        }

        $email = isset($payload['email']) ? mb_strtolower(trim((string) $payload['email'])) : '';
        $probe = $payload['embedding'] ?? null;

        if ($email === '' || !is_array($probe) || count($probe) < 64) {
            return $this->json(['ok' => false, 'message' => 'Email ou embedding invalide'], 400);
        }

        /** @var User|null $user */
        $user = $users->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['ok' => false, 'message' => 'Identifiants invalides'], 401);
        }

        // ✅ plus besoin de method_exists : $user est de type User
        if (!$user->isActive()) {
            return $this->json(['ok' => false, 'message' => 'Compte désactivé.'], 403);
        }

        $stored = $user->getFaceEmbedding();
        if (!is_array($stored) || count($stored) < 64) {
            return $this->json(['ok' => false, 'message' => 'Ce compte n’a pas de visage enregistré.'], 400);
        }

        // ✅ nettoyer l'embedding reçu
        $cleanProbe = [];
        foreach ($probe as $v) {
            $f = (float) $v;
            if (is_finite($f)) {
                $cleanProbe[] = $f;
            }
        }

        if (count($cleanProbe) !== count($stored)) {
            return $this->json(['ok' => false, 'message' => 'Embedding invalide'], 400);
        }

        if (!$faceService->isMatch($stored, $cleanProbe)) {
            return $this->json(['ok' => false, 'message' => '❌ Visage non reconnu'], 401);
        }

        // =====================================================
        // ✅ Connexion Symfony (session + token firewall main)
        // =====================================================
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());

        // régénère la session (anti fixation)
        $sessionStrategy->onAuthentication($request, $token);

        // stocke token
        $tokenStorage->setToken($token);
        $session->set('_security_main', serialize($token));
        $session->save();

        $route = $this->dashboardRouteFor($user);

        $response = new JsonResponse([
            'ok' => true,
            'message' => '✅ Connexion réussie',
            'redirect' => $this->generateUrl($route),
        ]);
        $response->headers->set('Cache-Control', 'no-store');

        return $response;
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - intercepted by logout key.');
    }
}