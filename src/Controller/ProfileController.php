<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CitoyenProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/citoyen/profil', name: 'citoyen_profile_show', methods: ['GET'])]
    public function show(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('citoyen/profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/citoyen/profil/modifier', name: 'citoyen_profile_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(CitoyenProfileType::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ✅ gestion changement mot de passe (optionnel)
            $currentPassword = (string) $form->get('currentPassword')->getData();
            $newPassword = (string) ($form->get('newPassword')->getData() ?? '');

            // si l’utilisateur a rempli "newPassword"
            if ($newPassword !== '') {
                // il doit fournir le mot de passe actuel
                if ($currentPassword === '' || !$passwordHasher->isPasswordValid($user, $currentPassword)) {
                    $this->addFlash('danger', 'Mot de passe actuel incorrect.');
                    return $this->redirectToRoute('citoyen/profile/citoyen_profile_edit');
                }

                $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            }

            $em->flush();

            $this->addFlash('success', 'Profil mis à jour ✅');
            return $this->redirectToRoute('citoyen_profile_show');
        }

        return $this->render('citoyen/profile/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}