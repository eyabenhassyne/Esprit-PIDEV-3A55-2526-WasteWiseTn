<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Entity\ReponseOffre;
use App\Repository\AppelOffreRepository;
use App\Repository\ReponseOffreRepository;
use App\Repository\UserRepository;
use App\Service\AdminAlertService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    // ─── Routes Gestion USER (Khalil) ────────────────────────────────────────

    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_dashboard_admin');
        }

        if ($this->isGranted('ROLE_VALORIZER')) {
            return $this->redirectToRoute('app_dashboard_valorizateur');
        }

        return $this->redirectToRoute('app_dashboard_citoyen');
    }

    #[Route('/dashboard/citoyen', name: 'app_dashboard_citoyen', methods: ['GET'])]
    public function citoyen(ReponseOffreRepository $reponseOffreRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recentReponses = $reponseOffreRepository->findRecentWithRelations(6);

        $declarations = array_map(
            fn (ReponseOffre $reponse): array => [
                'date' => $reponse->getDateSoumis()->format('d M'),
                'type' => $reponse->getAppelOffre()?->getTitre() ?? 'Offre',
                'quantite' => $reponse->getQuantiteProposee().' kg',
                'points' => $this->computeEcoPoints($reponse),
                'status' => $this->normalizeStatus($reponse->getStatut()),
            ],
            $recentReponses
        );

        $ecoPoints = array_reduce(
            $recentReponses,
            fn (int $total, ReponseOffre $reponse): int => $total + $this->computeEcoPoints($reponse),
            0
        );

        return $this->render('dashboard/citoyen.html.twig', [
            'declarations' => $declarations,
            'eco_points' => $ecoPoints,
        ]);
    }

    #[Route('/dashboard/admin', name: 'app_dashboard_admin', methods: ['GET'])]
    public function admin(
        UserRepository $userRepo,
        AppelOffreRepository $appelOffreRepository,
        ReponseOffreRepository $reponseOffreRepository,
        AdminAlertService $adminAlertService
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $now = new \DateTimeImmutable();
        $in7Days = $now->modify('+7 days');
        $startLast7 = $now->modify('-7 days');
        $startPrev7 = $now->modify('-14 days');
        $epoch = new \DateTimeImmutable('1970-01-01 00:00:00');

        $recentAppels = $appelOffreRepository->findBy([], ['id' => 'DESC'], 5);
        $recentReponses = $reponseOffreRepository->findRecentWithRelations(5);
        $statusDistributionAll = $reponseOffreRepository->getStatusDistributionBetween($epoch, $now);

        $totalAppels = $appelOffreRepository->count([]);
        $offresExpirees = $appelOffreRepository->countExpired();
        $offresActives = max(0, $totalAppels - $offresExpirees);
        $offresExpirentBientot = $appelOffreRepository->countUrgentActive($now, $in7Days);

        $totalEnAttente = $statusDistributionAll['en_attente'];
        $totalValidees = $statusDistributionAll['valide'];
        $totalRefusees = $statusDistributionAll['refuse'];
        $totalReponses = $totalEnAttente + $totalValidees + $totalRefusees + $statusDistributionAll['autre'];

        $tauxValidation = $totalReponses > 0 ? (int) round(($totalValidees / $totalReponses) * 100) : 0;
        $reponsesLast7 = $reponseOffreRepository->countCreatedBetween($startLast7, $now);
        $reponsesPrev7 = $reponseOffreRepository->countCreatedBetween($startPrev7, $startLast7);
        $trendReponsesPct = $reponsesPrev7 > 0
            ? (int) round((($reponsesLast7 - $reponsesPrev7) / $reponsesPrev7) * 100)
            : ($reponsesLast7 > 0 ? 100 : 0);
        $backlogRate = $totalReponses > 0 ? (int) round(($totalEnAttente / $totalReponses) * 100) : 0;
        $healthIndex = (int) round(max(0, min(100,
            (0.45 * $tauxValidation) + (0.35 * (100 - $backlogRate)) + (0.20 * max(0, 100 - ($offresExpirees * 5)))
        )));

        return $this->render('dashboard/admin.html.twig', [
            'usersTotal' => $userRepo->count([]),
            'lastUsers' => $userRepo->findBy([], ['createdAt' => 'DESC'], 5),
            'kpis' => [
                'total_appels' => $totalAppels,
                'offres_actives' => $offresActives,
                'offres_expirees' => $offresExpirees,
                'offres_expirent_bientot' => $offresExpirentBientot,
                'reponses_recues' => $totalReponses,
                'reponses_validees' => $totalValidees,
                'reponses_en_attente' => $totalEnAttente,
                'reponses_refusees' => $totalRefusees,
                'taux_validation' => $tauxValidation,
                'backlog_rate' => $backlogRate,
                'health_index' => $healthIndex,
                'reponses_last7' => $reponsesLast7,
                'trend_reponses_pct' => $trendReponsesPct,
            ],
            'recent_appels' => array_map(
                function (AppelOffre $appel) use ($now): array {
                    $dateLimite = $appel->getDateLimite();
                    $daysLeft = (int) $now->diff($dateLimite)->format('%r%a');
                    return [
                        'titre' => $appel->getTitre(),
                        'quantite' => $appel->getQuantiteDemandee().' kg',
                        'date_limite' => $dateLimite->format('Y-m-d'),
                        'est_expire' => $appel->isExpired($now),
                        'days_left' => $daysLeft,
                    ];
                },
                $recentAppels
            ),
            'recent_reponses' => array_map(
                fn (ReponseOffre $reponse): array => [
                    'citoyen' => trim(($reponse->getCitoyen()?->getPrenom() ?? '').' '.($reponse->getCitoyen()?->getNom() ?? '')) ?: 'Citoyen',
                    'offre' => $reponse->getAppelOffre()?->getTitre() ?? 'Offre',
                    'statut' => $this->normalizeStatus($reponse->getStatut()),
                ],
                $recentReponses
            ),
            'status_distribution' => [
                'validees' => $totalValidees,
                'en_attente' => $totalEnAttente,
                'refusees' => $totalRefusees,
            ],
            'alert_center' => $adminAlertService->buildAlertCenter($now),
        ]);
    }

    #[Route('/dashboard/valorisateur', name: 'app_dashboard_valorizateur', methods: ['GET'])]
    public function valorisateur(ReponseOffreRepository $reponseOffreRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_VALORIZER');

        $recentReponses = $reponseOffreRepository->findRecentWithRelations(6);

        $declarations = array_map(
            fn (ReponseOffre $reponse): array => [
                'date' => $reponse->getDateSoumis()->format('d M'),
                'type' => $reponse->getAppelOffre()?->getTitre() ?? 'Offre',
                'quantite' => $reponse->getQuantiteProposee().' kg',
                'points' => $this->computeEcoPoints($reponse),
                'status' => $this->normalizeStatus($reponse->getStatut()),
            ],
            $recentReponses
        );

        $ecoPoints = array_reduce(
            $recentReponses,
            fn (int $total, ReponseOffre $reponse): int => $total + $this->computeEcoPoints($reponse),
            0
        );

        return $this->render('dashboard/valorisateur.html.twig', [
            'declarations' => $declarations,
            'eco_points' => $ecoPoints,
        ]);
    }

    // ─── Routes Appels d'Offres (Mohamed) ────────────────────────────────────

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/offres', name: 'app_front_dashboard', methods: ['GET'])]
    public function front(ReponseOffreRepository $reponseOffreRepository): Response
    {
        $recentReponses = $reponseOffreRepository->findRecentWithRelations(6);

        $declarations = array_map(
            fn (ReponseOffre $reponse): array => [
                'date' => $reponse->getDateSoumis()->format('d M'),
                'type' => $reponse->getAppelOffre()?->getTitre() ?? 'Offre',
                'quantite' => $reponse->getQuantiteProposee().' kg',
                'points' => $this->computeEcoPoints($reponse),
                'status' => $this->normalizeStatus($reponse->getStatut()),
            ],
            $recentReponses
        );

        $ecoPoints = array_reduce(
            $recentReponses,
            fn (int $total, ReponseOffre $reponse): int => $total + $this->computeEcoPoints($reponse),
            0
        );

        return $this->render('dashboard/front.html.twig', [
            'declarations' => $declarations,
            'recompenses' => [
                ['label' => 'Bon d\'achat Carrefour 10 DT', 'cout' => 800],
                ['label' => 'Reduction transport public', 'cout' => 600],
                ['label' => 'Cafe gratuit chez Ben Yedder', 'cout' => 500],
            ],
            'eco_points' => $ecoPoints,
        ]);
    }

    #[Route('/back/dashboard', name: 'app_back_dashboard', methods: ['GET'])]
    public function back(
        AppelOffreRepository $appelOffreRepository,
        ReponseOffreRepository $reponseOffreRepository,
        AdminAlertService $adminAlertService
    ): Response {
        $now = new \DateTimeImmutable();
        $in7Days = $now->modify('+7 days');
        $startLast7 = $now->modify('-7 days');
        $startPrev7 = $now->modify('-14 days');
        $epoch = new \DateTimeImmutable('1970-01-01 00:00:00');

        $recentAppels = $appelOffreRepository->findBy([], ['id' => 'DESC'], 5);
        $recentReponses = $reponseOffreRepository->findRecentWithRelations(5);
        $statusDistributionAll = $reponseOffreRepository->getStatusDistributionBetween($epoch, $now);

        $totalAppels = $appelOffreRepository->count([]);
        $offresExpirees = $appelOffreRepository->countExpired();
        $offresActives = max(0, $totalAppels - $offresExpirees);
        $offresExpirentBientot = $appelOffreRepository->countUrgentActive($now, $in7Days);

        $totalEnAttente = $statusDistributionAll['en_attente'];
        $totalValidees = $statusDistributionAll['valide'];
        $totalRefusees = $statusDistributionAll['refuse'];
        $totalReponses = $totalEnAttente + $totalValidees + $totalRefusees + $statusDistributionAll['autre'];

        $tauxValidation = $totalReponses > 0
            ? (int) round(($totalValidees / $totalReponses) * 100)
            : 0;

        $reponsesLast7 = $reponseOffreRepository->countCreatedBetween($startLast7, $now);
        $reponsesPrev7 = $reponseOffreRepository->countCreatedBetween($startPrev7, $startLast7);
        $trendReponsesPct = $reponsesPrev7 > 0
            ? (int) round((($reponsesLast7 - $reponsesPrev7) / $reponsesPrev7) * 100)
            : ($reponsesLast7 > 0 ? 100 : 0);

        $backlogRate = $totalReponses > 0
            ? (int) round(($totalEnAttente / $totalReponses) * 100)
            : 0;

        $healthIndex = (int) round(
            max(0, min(100, (0.45 * $tauxValidation) + (0.35 * (100 - $backlogRate)) + (0.20 * max(0, 100 - ($offresExpirees * 5)))))
        );
        $alertCenter = $adminAlertService->buildAlertCenter($now);

        return $this->render('dashboard/back.html.twig', [
            'kpis' => [
                'total_appels' => $totalAppels,
                'offres_actives' => $offresActives,
                'offres_expirees' => $offresExpirees,
                'offres_expirent_bientot' => $offresExpirentBientot,
                'reponses_recues' => $totalReponses,
                'reponses_validees' => $totalValidees,
                'reponses_en_attente' => $totalEnAttente,
                'reponses_refusees' => $totalRefusees,
                'taux_validation' => $tauxValidation,
                'backlog_rate' => $backlogRate,
                'health_index' => $healthIndex,
                'reponses_last7' => $reponsesLast7,
                'trend_reponses_pct' => $trendReponsesPct,
            ],
            'recent_appels' => array_map(
                function (AppelOffre $appel) use ($now): array {
                    $dateLimite = $appel->getDateLimite();
                    $daysLeft = (int) $now->diff($dateLimite)->format('%r%a');

                    return [
                        'titre' => $appel->getTitre(),
                        'quantite' => $appel->getQuantiteDemandee().' kg',
                        'date_limite' => $dateLimite->format('Y-m-d'),
                        'est_expire' => $appel->isExpired($now),
                        'days_left' => $daysLeft,
                    ];
                },
                $recentAppels
            ),
            'recent_reponses' => array_map(
                fn (ReponseOffre $reponse): array => [
                    'citoyen' => trim(
                        ($reponse->getCitoyen()?->getPrenom() ?? '').' '.($reponse->getCitoyen()?->getNom() ?? '')
                    ) ?: 'Citoyen',
                    'offre' => $reponse->getAppelOffre()?->getTitre() ?? 'Offre',
                    'statut' => $this->normalizeStatus($reponse->getStatut()),
                ],
                $recentReponses
            ),
            'status_distribution' => [
                'validees' => $totalValidees,
                'en_attente' => $totalEnAttente,
                'refusees' => $totalRefusees,
            ],
            'alert_center' => $alertCenter,
        ]);
    }

    private function normalizeStatus(?string $status): string
    {
        $normalized = strtolower(trim(str_replace('_', ' ', $status ?? '')));

        if (in_array($normalized, ['valide', 'validee'], true)) {
            return 'valide';
        }

        if (in_array($normalized, ['en attente', 'pending'], true)) {
            return 'en attente';
        }

        return $normalized !== '' ? $normalized : 'en attente';
    }

    private function computeEcoPoints(ReponseOffre $reponse): int
    {
        $base = (int) round($reponse->getQuantiteProposee() * 10);

        return $this->normalizeStatus($reponse->getStatut()) === 'valide'
            ? $base
            : (int) round($base * 0.5);
    }
}
