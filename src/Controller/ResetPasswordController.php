<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\ResetPasswordTokenRepository;
use App\Service\ResetPasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password', methods: ['GET','POST'])]
    public function forgot(
        Request $request,
        EntityManagerInterface $em,
        ResetPasswordService $resetService
    ): Response {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            // ✅ (bonne pratique) message générique pour éviter l'énumération d'emails
            if ($user) {
                $token = $resetService->createToken($user, 30);
                $resetService->sendResetEmail($user, $token);
            }

            $this->addFlash('success', 'Si un compte existe avec cet email, un lien de réinitialisation a été envoyé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/forgot_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password', methods: ['GET','POST'])]
    public function reset(
        string $token,
        Request $request,
        ResetPasswordTokenRepository $tokenRepo,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $tokenEntity = $tokenRepo->findValidToken($token);

        if (!$tokenEntity) {
            $this->addFlash('danger', 'Lien invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plain = $form->get('plainPassword')->getData();
            $user = $tokenEntity->getUser();

            $user->setPassword($hasher->hashPassword($user, $plain));

            $tokenEntity->setUsedAt(new \DateTimeImmutable());
            $em->flush();

            $this->addFlash('success', 'Mot de passe changé.');
            return $this->redirectToRoute('app_login');
        }

        // ✅ FIX: on passe expiresAt au template
        return $this->render('auth/reset_password.html.twig', [
            'form' => $form->createView(),
            'expiresAt' => $tokenEntity->getExpiresAt(),
        ]);
    }
}