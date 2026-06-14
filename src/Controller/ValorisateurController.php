<?php

namespace App\Controller;

use App\Entity\DeclarationDechet;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ValorisateurProfileType;
use App\Repository\DeclarationDechetRepository;
use App\Repository\UserRepository;
use App\Service\EcoPointsService;
use App\Service\WeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_VALORIZER')]
class ValorisateurController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    #[Route('/valorisateur/dashboard', name: 'valorisateur_dashboard')]
    public function dashboard(
        WeatherService $weatherService,
        DeclarationDechetRepository $declarationRepository
    ): Response
    {
        return $this->render('valorisateur/dashboard.html.twig', array_merge(
            $this->buildValorisateurStatsData($declarationRepository),
            [
            'weather' => $weatherService->getCurrentWeather(),
            ]
        ));
    }

    #[Route('/valorisateur/dechets', name: 'valorisateur_dechets')]
    public function dechetsRecus(DeclarationDechetRepository $declarationRepository): Response
    {
        $declarations = $declarationRepository->findBy([], ['createdAt' => 'DESC']);
        $totalDeclarations = \count($declarations);
        $pendingCount = 0;
        $approvedCount = 0;

        foreach ($declarations as $declaration) {
            if ($this->isApprovedStatus((string) $declaration->getStatut())) {
                ++$approvedCount;
            } else {
                ++$pendingCount;
            }
        }

        return $this->render('valorisateur/dechets.html.twig', [
            'declarations' => $declarations,
            'totalDeclarations' => $totalDeclarations,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
        ]);
    }

    #[Route('/valorisateur/dechets/{id}/confirmer', name: 'valorisateur_confirmer', methods: ['POST'])]
    public function confirmer(
        DeclarationDechet $declaration,
        Request $request,
        EntityManagerInterface $entityManager,
        EcoPointsService $ecoPointsService
    ): Response {
        $csrfToken = (string) $request->request->get('_token', '');
        $isAjax = $request->isXmlHttpRequest();

        if (!$this->isCsrfTokenValid('confirm_'.$declaration->getId(), $csrfToken)) {
            return $this->jsonOrRedirect($isAjax, [
                'status' => 'error',
                'message' => 'Token CSRF invalide.',
            ], 'error');
        }

        $result = $this->processApproval($declaration, $entityManager, $ecoPointsService);
        $flashType = $result['status'] === 'success' ? 'success' : ($result['status'] === 'warning' ? 'warning' : 'error');

        return $this->jsonOrRedirect($isAjax, $result, $flashType);
    }

    #[Route('/valorisateur/valider/{id}', name: 'valorisateur_valider_qr', methods: ['GET'])]
    public function validerQr(
        DeclarationDechet $declaration,
        EntityManagerInterface $entityManager,
        EcoPointsService $ecoPointsService
    ): Response {
        $result = $this->processApproval($declaration, $entityManager, $ecoPointsService);
        $flashType = $result['status'] === 'success' ? 'success' : ($result['status'] === 'warning' ? 'warning' : 'error');
        $this->addFlash($flashType, $result['message']);

        return $this->redirectToRoute('valorisateur_dechets');
    }

    #[Route('/valorisateur/valorisation', name: 'valorisateur_valorisation')]
    public function valorisation(DeclarationDechetRepository $declarationRepository): Response
    {
        $declarations = $declarationRepository->createQueryBuilder('d')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        $totalKg = (float) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->getQuery()
            ->getSingleScalarResult();

        $totalPoints = (int) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.pointsAttribues), 0)')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('valorisateur/valorisation.html.twig', [
            'declarations' => $declarations,
            'totalKg' => $totalKg,
            'totalPoints' => $totalPoints,
        ]);
    }

    #[Route('/valorisateur/statistiques', name: 'valorisateur_statistiques')]
    public function statistiques(DeclarationDechetRepository $declarationRepository): Response
    {
        return $this->render('valorisateur/statistiques.html.twig', $this->buildValorisateurStatsData($declarationRepository));
    }

    #[Route('/valorisateur/parametres', name: 'valorisateur_parametres')]
    public function parametres(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        // TODO: remplacer par $this->getUser() apres integration auth.
        $user = $this->resolveValorisateurDemo($userRepository, $entityManager, $passwordHasher);

        // On separe profil/securite pour garder une interface claire et facile a maintenir.
        $profileForm = $this->createForm(ValorisateurProfileType::class, $user);
        $profileForm->handleRequest($request);

        $passwordForm = $this->createForm(ChangePasswordType::class);
        $passwordForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $photoFile = $profileForm->get('photoProfilFile')->getData();
            if ($photoFile) {
                $safeName = $slugger->slug(pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME));
                $extension = strtolower(trim((string) pathinfo((string) $photoFile->getClientOriginalName(), PATHINFO_EXTENSION)));
                if ('' === $extension || !preg_match('/^[a-z0-9]+$/', $extension)) {
                    $extension = 'bin';
                }
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($extension, $allowedExtensions, true)) {
                    $this->addFlash('error', 'Format autorise: JPG, JPEG, PNG, WEBP.');

                    return $this->redirectToRoute('valorisateur_parametres');
                }

                $newFilename = $safeName.'-'.uniqid().'.'.$extension;
                $uploadDir = $this->getParameter('profiles_upload_directory');
                if (!is_string($uploadDir) || '' === trim($uploadDir)) {
                    throw new \RuntimeException('Configuration profiles_upload_directory invalide.');
                }

                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0775, true);
                }

                try {
                    $photoFile->move($uploadDir, $newFilename);
                    $user->setPhotoProfil($newFilename);
                } catch (FileException) {
                    $this->addFlash('error', 'Impossible de televerser la photo de profil.');
                }
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil valorisateur mis a jour avec succes.');

            return $this->redirectToRoute('valorisateur_parametres');
        }

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $currentPassword = (string) $passwordForm->get('currentPassword')->getData();
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Mot de passe actuel incorrect.');

                return $this->redirectToRoute('valorisateur_parametres');
            }

            $plainPassword = (string) $passwordForm->get('plainPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe modifie avec succes.');

            return $this->redirectToRoute('valorisateur_parametres');
        }

        return $this->render('valorisateur/parametres.html.twig', [
            'user' => $user,
            'profileForm' => $profileForm->createView(),
            'passwordForm' => $passwordForm->createView(),
        ]);
    }

    private function resolveValorisateurDemo(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): User {
        $user = $userRepository->findOneBy(['email' => 'demo@wastewise.tn']);
        if ($user instanceof User) {
            return $user;
        }

        $user = (new User())
            ->setNom('Utilisateur')
            ->setPrenom('Demo')
            ->setEmail('demo@wastewise.tn')
            ->setRoles(['ROLE_VALORIZER'])
            ->setOrganisationCentre('Centre Demo')
            ->setStatutCentre('ACTIF');

        $user->setPassword($passwordHasher->hashPassword($user, 'demo123456'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * @return array{status: string, message: string, points?: int}
     */
    private function processApproval(
        DeclarationDechet $declaration,
        EntityManagerInterface $entityManager,
        EcoPointsService $ecoPointsService
    ): array {
        $status = strtoupper(trim((string) $declaration->getStatut()));

        if ($this->isApprovedStatus($status)) {
            return [
                'status' => 'warning',
                'message' => 'Cette declaration est deja approuvee.',
            ];
        }

        if (!\in_array($status, [DeclarationDechet::STATUT_EN_ATTENTE, 'PENDING'], true)) {
            return [
                'status' => 'error',
                'message' => 'Statut invalide pour confirmation.',
            ];
        }

        if ($declaration->getPointsAttribues() > 0) {
            return [
                'status' => 'warning',
                'message' => 'Points deja attribues pour cette declaration.',
            ];
        }

        $citoyen = $declaration->getCitoyen();
        if (!$citoyen instanceof User) {
            return [
                'status' => 'error',
                'message' => 'Aucun citoyen associe a cette declaration.',
            ];
        }

        try {
            $points = $ecoPointsService->calculatePointsFromDeclaration($declaration);

            $declaration->setStatut(DeclarationDechet::STATUT_APPROUVEE);
            $declaration->setPointsAttribues($points);
            $declaration->setDateConfirmation(new \DateTimeImmutable());

            $actorName = 'Valorisateur';
            $actor = $this->getUser();
            if ($actor instanceof User) {
                $declaration->setValorisateurConfirmateur($actor);
                $actorName = trim((string) ($actor->getPrenom().' '.$actor->getNom())) ?: (string) $actor->getEmail();
            }

            $declaration->addHistoriqueStatut(
                DeclarationDechet::STATUT_APPROUVEE,
                $actorName,
                'Declaration confirmee par valorisateur'
            );

            $ecoPointsService->addPoints($citoyen, $points, 'Declaration approuvee par valorisateur', false);

            $entityManager->persist($declaration);
            $entityManager->flush();

            return [
                'status' => 'success',
                'message' => 'Declaration approuvee et points attribues.',
                'points' => $points,
            ];
        } catch (\Throwable $exception) {
            $this->logger->error('Echec validation declaration par valorisateur', [
                'declaration_id' => $declaration->getId(),
                'status' => $status,
                'error' => $exception->getMessage(),
            ]);

            return [
                'status' => 'error',
                'message' => 'Erreur lors de la validation de la declaration.',
            ];
        }
    }

    /**
     * @return array{
     *     totalRecues: int,
     *     totalValidees: int,
     *     totalEnAttente: int,
     *     totalKgRecus: float,
     *     totalKgValides: float,
     *     totalPoints: int,
     *     rendement: float,
     *     validationsToday: int,
     *     kgToday: float,
     *     badge: string,
     *     kgToNext: float,
     *     pendingAlert: bool,
     *     noValidationAlert: bool
     * }
     */
    private function buildValorisateurStatsData(DeclarationDechetRepository $declarationRepository): array
    {
        $totalRecues = $declarationRepository->count([]);
        $totalValidees = (int) $declarationRepository->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->getQuery()
            ->getSingleScalarResult();
        $totalEnAttente = $declarationRepository->count(['statut' => DeclarationDechet::STATUT_EN_ATTENTE]);

        $totalKgRecus = (float) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalKgValides = (float) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->getQuery()
            ->getSingleScalarResult();

        $totalPoints = (int) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.pointsAttribues), 0)')
            ->where('d.statut IN (:approvedStatuses)')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->getQuery()
            ->getSingleScalarResult();

        $rendement = $totalKgRecus > 0 ? round(($totalKgValides / $totalKgRecus) * 100, 2) : 0.0;

        $todayStart = new \DateTimeImmutable('today');
        $todayEnd = $todayStart->modify('+1 day');
        $validationsToday = (int) $declarationRepository->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.statut IN (:approvedStatuses)')
            ->andWhere('d.dateConfirmation IS NOT NULL')
            ->andWhere('d.dateConfirmation >= :todayStart')
            ->andWhere('d.dateConfirmation < :todayEnd')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->setParameter('todayStart', $todayStart)
            ->setParameter('todayEnd', $todayEnd)
            ->getQuery()
            ->getSingleScalarResult();

        $kgToday = (float) $declarationRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.statut IN (:approvedStatuses)')
            ->andWhere('d.dateConfirmation IS NOT NULL')
            ->andWhere('d.dateConfirmation >= :todayStart')
            ->andWhere('d.dateConfirmation < :todayEnd')
            ->setParameter('approvedStatuses', [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'])
            ->setParameter('todayStart', $todayStart)
            ->setParameter('todayEnd', $todayEnd)
            ->getQuery()
            ->getSingleScalarResult();

        $badge = 'Bronze Recycler';
        $nextBadgeAt = 100;
        if ($totalKgValides >= 700) {
            $badge = 'Eco Master';
            $nextBadgeAt = 700;
        } elseif ($totalKgValides >= 301) {
            $badge = 'Gold Recycler';
            $nextBadgeAt = 700;
        } elseif ($totalKgValides >= 101) {
            $badge = 'Silver Recycler';
            $nextBadgeAt = 301;
        }

        return [
            'totalRecues' => $totalRecues,
            'totalValidees' => $totalValidees,
            'totalEnAttente' => $totalEnAttente,
            'totalKgRecus' => $totalKgRecus,
            'totalKgValides' => $totalKgValides,
            'totalPoints' => $totalPoints,
            'rendement' => $rendement,
            'validationsToday' => $validationsToday,
            'kgToday' => $kgToday,
            'badge' => $badge,
            'kgToNext' => max(0, $nextBadgeAt - $totalKgValides),
            'pendingAlert' => $totalEnAttente > 20,
            'noValidationAlert' => $validationsToday === 0,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function jsonOrRedirect(bool $isAjax, array $payload, string $flashType): Response
    {
        if ($isAjax) {
            return new JsonResponse($payload);
        }

        $this->addFlash($flashType, (string) ($payload['message'] ?? 'Operation terminee.'));

        return $this->redirectToRoute('valorisateur_dechets');
    }

    private function isApprovedStatus(string $status): bool
    {
        return \in_array(strtoupper(trim($status)), [DeclarationDechet::STATUT_APPROUVEE, 'VALIDATED'], true);
    }
}
