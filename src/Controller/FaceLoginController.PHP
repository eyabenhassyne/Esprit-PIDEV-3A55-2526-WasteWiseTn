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
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

class FaceLoginController extends AbstractController
{
    #[Route('/face-login', name: 'app_face_login', methods: ['GET'])]
    public function page(Request $request): Response
    {
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
    public function verify(
        Request $request,
        UserRepository $users,
        FaceService $faceService,
        TokenStorageInterface $tokenStorage,
        SessionAuthenticationStrategyInterface $sessionStrategy
    ): JsonResponse {
        $payload = json_decode($request->getContent(), true) ?? [];

        $email = isset($payload['email']) ? mb_strtolower(trim((string)$payload['email'])) : '';
        $probe = $payload['embedding'] ?? null;

        if ($email === '' || !is_array($probe) || count($probe) < 64) {
            return $this->json(['ok' => false, 'message' => 'Email ou embedding invalide'], 400);
        }

        /** @var User|null $user */
        $user = $users->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['ok' => false, 'message' => 'Identifiants invalides'], 401);
        }

        if (method_exists($user, 'isActive') && !$user->isActive()) {
            return $this->json(['ok' => false, 'message' => 'Compte désactivé.'], 403);
        }

        $stored = $user->getFaceEmbedding();
        if (!is_array($stored) || count($stored) < 64) {
            return $this->json(['ok' => false, 'message' => 'Ce compte n’a pas de visage enregistré.'], 400);
        }

        // nettoyage embedding
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
        // ✅ LOGIN SYMFONY CORRECT (token + session strategy)
        // =====================================================
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        // ✅ régénère la session comme Symfony après login (anti fixation)
        $sessionStrategy->onAuthentication($request, new UsernamePasswordToken($user, 'main', $user->getRoles()));

        // ✅ crée et stocke le token
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $tokenStorage->setToken($token);

        // ✅ stocke dans la session du firewall main (obligatoire)
        $session->set('_security_main', serialize($token));
        $session->save();

        // =====================================================

        $route = $this->dashboardRouteFor($user);

        $response = new JsonResponse([
            'ok' => true,
            'message' => '✅ Connexion réussie',
            'redirect' => $this->generateUrl($route),
        ]);

        $response->headers->set('Cache-Control', 'no-store');

        return $response;
    }
}
