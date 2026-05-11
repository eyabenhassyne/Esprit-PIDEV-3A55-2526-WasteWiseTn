<?php

namespace App\Controller;

use App\Entity\DeclarationDechet;
use App\Entity\User;
use App\Form\DeclarationDechetType;
use App\Repository\UserRepository;
use App\Service\VisionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DeclarationDechetController extends AbstractController
{
    #[Route('/citoyen/declaration', name: 'citoyen_declaration')]
    #[Route('/citoyen/declaration/new', name: 'declaration_dechet_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        UserRepository $userRepository
    ): Response {
        $declaration = new DeclarationDechet();
        $form = $this->createForm(DeclarationDechetType::class, $declaration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($declaration->getLatitude() === null || $declaration->getLongitude() === null) {
                $form->addError(new FormError('Veuillez selectionner un emplacement sur la carte.'));

                return $this->render('declaration_dechet/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $photoFile = $form->get('photoFile')->getData();
            if (!$photoFile) {
                $form->get('photoFile')->addError(new FormError('Veuillez ajouter une photo du dechet.'));

                return $this->render('declaration_dechet/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

            try {
                $photoFile->move($this->getParameter('dechets_upload_directory'), $newFilename);
            } catch (FileException) {
                $form->addError(new FormError('Impossible de televerser la photo.'));

                return $this->render('declaration_dechet/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $scoreIaFromRequest = $request->request->all('declaration_dechet')['scoreIa'] ?? null;

            $declaration->setPhoto($newFilename);
            $declaration->setStatut(DeclarationDechet::STATUT_EN_ATTENTE);
            $declaration->setPointsAttribues(0);
            $declaration->setCreatedAt(new \DateTime());
            $declaration->setCitoyen($this->resolveDeclarationAuthor($userRepository));
            $declaration->setValorisateurConfirmateur(null);
            $declaration->setDateConfirmation(null);
            $declaration->setDeletedAt(null);
            $declaration->setStatutHistorique([]);

            $citoyen = $declaration->getCitoyen();
            $actor = $citoyen instanceof User
                ? (trim((string) ($citoyen->getPrenom().' '.$citoyen->getNom())) ?: (string) $citoyen->getEmail())
                : 'Citoyen';
            $declaration->addHistoriqueStatut(
                DeclarationDechet::STATUT_EN_ATTENTE,
                $actor,
                'Declaration creee'
            );

            if (null !== $scoreIaFromRequest && is_numeric($scoreIaFromRequest)) {
                $declaration->setScoreIa((float) $scoreIaFromRequest);
            }

            $em->persist($declaration);
            $em->flush();

            // On flush une 1ere fois pour recuperer l'ID, puis on genere l'URL QR de validation terrain.
            $validationUrl = $this->generateUrl('valorisateur_valider_qr', [
                'id' => $declaration->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($validationUrl);
            $declaration->setQrCode($qrUrl);
            $em->flush();

            $this->addFlash('success', 'Declaration envoyee, en attente de validation.');

            return $this->redirectToRoute('citoyen_declarations');
        }

        return $this->render('declaration_dechet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/citoyen/analyse-image', name: 'citoyen_analyse_image', methods: ['POST'])]
    public function analyseImage(Request $request, VisionService $visionService): JsonResponse
    {
        $uploadedFile = $request->files->get('image') ?? $request->files->get('photo');
        $selectedType = (string) ($request->request->get('selectedType') ?? $request->request->get('typeLabel', ''));

        if (!$uploadedFile) {
            return $this->json([
                'success' => false,
                'label' => null,
                'score' => null,
                'match' => false,
                'error' => 'Aucune image envoyee.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $visionResult = $visionService->classifyImage($uploadedFile->getPathname());
        if (!($visionResult['success'] ?? false)) {
            return $this->json([
                'success' => false,
                'label' => null,
                'score' => null,
                'match' => false,
                'error' => $visionResult['error'] ?? 'Erreur IA.',
            ], Response::HTTP_OK);
        }

        $label = (string) ($visionResult['label'] ?? '');
        $score = (float) ($visionResult['score'] ?? 0);
        $typeMatches = $this->isTypeMatchingLabel($selectedType, $label);
        $match = !($score > 0.6 && !$typeMatches);

        return $this->json([
            'success' => true,
            'label' => $label,
            'score' => $score,
            'match' => $match,
            'error' => null,
        ]);
    }

    private function resolveDeclarationAuthor(UserRepository $userRepository): ?User
    {
        $securityUser = $this->getUser();
        if ($securityUser instanceof User) {
            return $securityUser;
        }

        $demoUser = $userRepository->findOneBy(['email' => 'demo@wastewise.tn']);
        if ($demoUser instanceof User) {
            return $demoUser;
        }

        return $userRepository->find(1);
    }

    private function isTypeMatchingLabel(string $selectedType, string $label): bool
    {
        $type = $this->normalizeText($selectedType);
        $predicted = $this->normalizeText($label);

        if ('' === $type || '' === $predicted) {
            return false;
        }

        if (str_contains($predicted, $type) || str_contains($type, $predicted)) {
            return true;
        }

        $aliases = [
            'plastique' => ['plastic', 'bottle', 'pet', 'container'],
            'carton' => ['carton', 'cardboard', 'box'],
            'papier' => ['paper', 'newspaper', 'notebook'],
            'verre' => ['glass', 'bottle'],
            'metal' => ['metal', 'can', 'aluminum', 'steel'],
            'canette' => ['can', 'aluminum'],
        ];

        foreach ($aliases as $family => $keywords) {
            $typeInFamily = str_contains($type, $family);
            $labelInFamily = false;
            foreach ($keywords as $keyword) {
                if (str_contains($predicted, $keyword)) {
                    $labelInFamily = true;
                    break;
                }
            }

            if ($typeInFamily && $labelInFamily) {
                return true;
            }
        }

        return false;
    }

    private function normalizeText(string $value): string
    {
        $value = strtolower(trim($value));
        $value = str_replace(['é', 'è', 'ê', 'à', 'ù', 'ô', 'î', 'ï', 'ç'], ['e', 'e', 'e', 'a', 'u', 'o', 'i', 'i', 'c'], $value);

        return preg_replace('/\s+/', ' ', $value) ?? '';
    }
}
