<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $repo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->has('plainPassword')) {
                $plainPassword = (string) $form->get('plainPassword')->getData();
                if ($plainPassword === '') {
                    $this->addFlash('danger', '❌ Mot de passe obligatoire.');
                    return $this->render('admin/user/new.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }
                $user->setPassword($hasher->hashPassword($user, $plainPassword));
            } else {
                $user->setPassword($hasher->hashPassword($user, (string) $user->getPassword()));
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', '✅ Utilisateur créé avec succès.');
            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $form = $this->createForm(UserType::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->has('plainPassword')) {
                $plainPassword = (string) $form->get('plainPassword')->getData();
                if ($plainPassword !== '') {
                    $user->setPassword($hasher->hashPassword($user, $plainPassword));
                }
            }

            $em->flush();

            $this->addFlash('success', '✅ Utilisateur mis à jour avec succès.');
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_user_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_user_' . $user->getId(), (string) $request->request->get('_token'))) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', '🗑️ Utilisateur supprimé.');
        } else {
            $this->addFlash('danger', '❌ Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_user_index');
    }

    /**
     * ✅ AJAX JSON : activer/désactiver un user
     * Règles:
     * - Admin seulement
     * - Ne pas désactiver soi-même
     * - Ne pas désactiver un ADMIN
     * - Ne pas désactiver si "en ligne" (lastSeenAt récent)
     * - CSRF via header X-CSRF-TOKEN
     */
    #[Route('/{id}/toggle-active', name: 'app_user_toggle_active', methods: ['POST'])]
    public function toggleActive(Request $request, User $user, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->json([
                'success' => false,
                'message' => 'Access Denied',
            ], 403);
        }

        $me = $this->getUser();
        if ($me instanceof User && $user->getId() === $me->getId()) {
            return $this->json([
                'success' => false,
                'message' => "Impossible de désactiver votre propre compte.",
            ], 400);
        }

        // ✅ Ne jamais désactiver un admin
        if ($user->getType() === User::TYPE_ADMIN) {
            return $this->json([
                'success' => false,
                'message' => "Impossible de désactiver un administrateur.",
            ], 400);
        }

        // ✅ Si on veut désactiver (user actif actuellement) ET il est en ligne => refus
        // On considère "en ligne" si lastSeenAt < 5 minutes
        if ($user->isActive()) {
            $lastSeen = $user->getLastSeenAt();
            if ($lastSeen && $lastSeen > new \DateTimeImmutable('-5 minutes')) {
                return $this->json([
                    'success' => false,
                    'message' => "❌ Impossible : cet utilisateur est actuellement connecté (en ligne).",
                ], 400);
            }
        }

        $token = $request->headers->get('X-CSRF-TOKEN');
        if (!$this->isCsrfTokenValid('toggle_user_' . $user->getId(), (string) $token)) {
            return $this->json([
                'success' => false,
                'message' => 'CSRF invalide',
            ], 403);
        }

        $user->setIsActive(!$user->isActive());
        $em->flush();

        return $this->json([
            'success' => true,
            'active' => $user->isActive(),
        ]);
    }
}
