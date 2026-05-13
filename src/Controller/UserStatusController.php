<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin/user')]
class UserStatusController extends AbstractController
{
    #[Route('/{id}/toggle-active', name: 'admin_user_toggle_active', methods: ['POST'])]
    public function toggleActive(
        int $id,
        Request $request,
        UserRepository $userRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        } catch (AccessDeniedException $e) {
            // ✅ toujours JSON (important pour fetch)
            return $this->json(['ok' => false, 'message' => "Accès refusé (ROLE_ADMIN requis)."], 403);
        }

        $user = $userRepo->find($id);
        if (!$user) {
            return $this->json(['ok' => false, 'message' => 'Utilisateur introuvable'], 404);
        }

        // empêcher l’admin de se désactiver lui-même
        $me = $this->getUser();
        if ($me && method_exists($me, 'getId') && $me->getId() === $user->getId()) {
            return $this->json(['ok' => false, 'message' => 'Impossible de désactiver votre propre compte'], 400);
        }

        $active = filter_var($request->request->get('active'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($active === null) {
            return $this->json(['ok' => false, 'message' => 'Paramètre "active" invalide'], 400);
        }

        // autoriser فقط CITIZEN/VALORIZER
        if (!in_array($user->getType(), ['CITIZEN', 'VALORIZER'], true)) {
            return $this->json(['ok' => false, 'message' => 'Action autorisée فقط sur citoyen/valorisateur'], 403);
        }

        $user->setIsActive($active);
        $em->flush();

        return $this->json([
            'ok' => true,
            'id' => $user->getId(),
            'active' => $user->isActive(),
        ]);
    }
}
