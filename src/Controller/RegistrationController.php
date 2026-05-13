<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ✅ sécurité: ne jamais permettre ADMIN depuis formulaire
            if ($user->getType() === User::TYPE_ADMIN) {
                $user->setType(User::TYPE_CITIZEN);
            }

            // ✅ si type vide -> citizen
            if (!$user->getType()) {
                $user->setType(User::TYPE_CITIZEN);
            }

            // ✅ mot de passe
            $plainPassword = (string) $form->get('plainPassword')->getData();
            if (trim($plainPassword) === '') {
                $this->addFlash('danger', 'Le mot de passe est obligatoire.');
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }

            $user->setPassword($hasher->hashPassword($user, $plainPassword));

            // ✅ visage optionnel (embedding en JSON)
            $raw = $request->request->get('faceEmbedding');
            if (is_string($raw) && trim($raw) !== '') {
                $arr = json_decode($raw, true);
                if (is_array($arr)) {
                    $clean = [];
                    foreach ($arr as $v) {
                        $f = (float) $v;
                        if (is_finite($f)) {
                            $clean[] = $f;
                        }
                    }
                    if (count($clean) >= 64) {
                        $user->setFaceEmbedding($clean);
                    }
                }
            }

            // ✅ sauver user
            $em->persist($user);
            $em->flush();

            // ✅ message + redirection vers login
            $this->addFlash('success', 'Compte créé avec succès. Connecte-toi maintenant.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}