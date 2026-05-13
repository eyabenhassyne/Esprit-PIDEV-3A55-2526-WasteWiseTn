<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CitoyenProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/valorisateur')]
#[IsGranted('ROLE_VALORIZER')]
class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'valorisateur_profile_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('valorisateur/profil/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/modifier', name: 'valorisateur_profile_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $form = $this->createForm(CitoyenProfileType::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var mixed $newPassword */
            $newPassword = $form->get('newPassword')->getData();
            /** @var mixed $currentPassword */
            $currentPassword = $form->get('currentPassword')->getData();

            // newPassword peut venir d'un RepeatedType => array('first' => ..., 'second' => ...)
            if (is_array($newPassword)) {
                $newPassword = $newPassword['first'] ?? '';
            }

            $newPassword = is_string($newPassword) ? trim($newPassword) : '';
            $currentPassword = is_string($currentPassword) ? trim($currentPassword) : '';

            // ✅ Validation custom du changement de mot de passe
            if ($newPassword !== '') {
                if ($currentPassword === '') {
                    $form->get('currentPassword')->addError(
                        new FormError('Veuillez saisir votre mot de passe actuel.')
                    );
                } elseif (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                    $form->get('currentPassword')->addError(
                        new FormError('Mot de passe actuel incorrect.')
                    );
                } else {
                    $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
                }
            }

            // ✅ Un seul isValid() (après avoir éventuellement ajouté des erreurs)
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Profil mis à jour avec succès.');
                return $this->redirectToRoute('valorisateur_profile_show');
            }
        }

        return $this->render('valorisateur/profil/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}