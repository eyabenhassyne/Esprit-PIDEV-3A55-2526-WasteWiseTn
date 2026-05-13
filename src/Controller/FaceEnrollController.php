<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/citoyen')]
#[IsGranted('ROLE_USER')]
class FaceEnrollController extends AbstractController
{
    #[Route('/face/enroll', name: 'citoyen_face_enroll_page', methods: ['GET'])]
    public function page(): Response
    {
        return $this->render('citoyen/face/enroll.html.twig');
    }

    #[Route('/face/enroll', name: 'citoyen_face_enroll_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->json(['ok' => false, 'message' => 'Utilisateur non connecté'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $embedding = $data['embedding'] ?? null;

        if (!is_array($embedding) || count($embedding) < 64) {
            return $this->json(['ok' => false, 'message' => 'Embedding invalide'], 400);
        }

        // Nettoyage + cast float
        $clean = [];
        foreach ($embedding as $v) {
            $f = (float) $v;
            if (is_finite($f)) {
                $clean[] = $f;
            }
        }

        if (count($clean) < 64) {
            return $this->json(['ok' => false, 'message' => 'Embedding invalide (valeurs non valides)'], 400);
        }

        $user->setFaceEmbedding($clean);
        $em->flush();

        return $this->json(['ok' => true, 'message' => '✅ Visage enregistré avec succès.']);
    }
}
