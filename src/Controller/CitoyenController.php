<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DeclarationDechet;
use App\Repository\DeclarationDechetRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Service\EcoPointsService;
use App\Service\NewsService;
use App\Service\OpenAqService;
use App\Service\StripeWithdrawService;
use App\Service\WeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitoyenController extends AbstractController
{
    #[Route('/citoyen/dashboard', name: 'citoyen_dashboard')]
    public function dashboard(
        WeatherService $weatherService,
        DeclarationDechetRepository $declarationRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->resolveCurrentUser($userRepository);

        $totalDeclarations = 0;
        $totalValidees = 0;
        $totalEnAttente = 0;
        $totalPoints = 0;
        $totalKg = 0.0;
        $monthlyLabels = [];
        $monthlyDeclarations = [];
        $monthlyPoints = [];
        $monthlyKg = [];
        $statusSplit = [0, 0, 0];

        if ($user instanceof User) {
            $totalDeclarations = $declarationRepository->count(['citoyen' => $user]);
            $totalValidees = $declarationRepository->count([
                'citoyen' => $user,
                'statut' => DeclarationDechet::STATUT_APPROUVEE,
            ]);
            $totalEnAttente = $declarationRepository->count([
                'citoyen' => $user,
                'statut' => DeclarationDechet::STATUT_EN_ATTENTE,
            ]);

            $totalPoints = (int) $declarationRepository->createQueryBuilder('d')
                ->select('COALESCE(SUM(d.pointsAttribues), 0)')
                ->where('d.citoyen = :user')
                ->andWhere('d.statut = :approved')
                ->setParameter('user', $user)
                ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
                ->getQuery()
                ->getSingleScalarResult();

            $totalKg = (float) $declarationRepository->createQueryBuilder('d')
                ->select('COALESCE(SUM(d.quantite), 0)')
                ->where('d.citoyen = :user')
                ->setParameter('user', $user)
                ->getQuery()
                ->getSingleScalarResult();

            $refusees = (int) $declarationRepository->createQueryBuilder('d')
                ->select('COUNT(d.id)')
                ->where('d.citoyen = :user')
                ->andWhere('d.statut = :refused')
                ->setParameter('user', $user)
                ->setParameter('refused', DeclarationDechet::STATUT_REFUSEE)
                ->getQuery()
                ->getSingleScalarResult();
            $statusSplit = [$totalValidees, $totalEnAttente, $refusees];

            $currentMonth = new \DateTimeImmutable('first day of this month');
            $months = [];
            for ($i = 5; $i >= 0; --$i) {
                $months[] = $currentMonth->modify(sprintf('-%d month', $i))->format('Y-m');
            }

            $connection = $entityManager->getConnection();
            $rows = $connection->fetchAllAssociative("
                SELECT DATE_FORMAT(created_at, '%Y-%m') AS bucket,
                       COUNT(*) AS declarations_count,
                       COALESCE(SUM(points_attribues), 0) AS points_total,
                       COALESCE(SUM(quantite), 0) AS kg_total
                FROM declaration_dechet
                WHERE citoyen_id = :citoyenId
                GROUP BY YEAR(created_at), MONTH(created_at)
                ORDER BY YEAR(created_at), MONTH(created_at)
            ", [
                'citoyenId' => $user->getId(),
            ]);

            $byMonth = [];
            foreach ($rows as $row) {
                $bucket = (string) ($row['bucket'] ?? '');
                if ('' === $bucket) {
                    continue;
                }
                $byMonth[$bucket] = [
                    'declarations' => (int) ($row['declarations_count'] ?? 0),
                    'points' => (int) ($row['points_total'] ?? 0),
                    'kg' => (float) ($row['kg_total'] ?? 0),
                ];
            }

            $monthlyLabels = array_map(static function (string $bucket): string {
                [$year, $month] = explode('-', $bucket);
                return sprintf('%02d/%s', (int) $month, $year);
            }, $months);

            $monthlyDeclarations = array_map(static fn (string $bucket): int => (int) (($byMonth[$bucket]['declarations'] ?? 0)), $months);
            $monthlyPoints = array_map(static fn (string $bucket): int => (int) (($byMonth[$bucket]['points'] ?? 0)), $months);
            $monthlyKg = array_map(static fn (string $bucket): float => (float) (($byMonth[$bucket]['kg'] ?? 0)), $months);
        }

        return $this->render('citoyen/dashboard.html.twig', [
            'weather' => $weatherService->getCurrentWeather(),
            'totalDeclarations' => $totalDeclarations,
            'totalValidees' => $totalValidees,
            'totalEnAttente' => $totalEnAttente,
            'totalPoints' => $totalPoints,
            'totalKg' => $totalKg,
            'monthlyLabels' => $monthlyLabels,
            'monthlyDeclarations' => $monthlyDeclarations,
            'monthlyPoints' => $monthlyPoints,
            'monthlyKg' => $monthlyKg,
            'statusSplit' => $statusSplit,
        ]);
    }

    #[Route('/citoyen/declarations', name: 'citoyen_declarations')]
    public function declarations(
        Request $request,
        DeclarationDechetRepository $declarationRepository,
        UserRepository $userRepository
    ): Response {
        $user = $this->resolveCurrentUser($userRepository);
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 20;

        $declarations = [];
        $totalDeclarations = 0;
        $pages = 1;
        $viewScope = 'mine';
        if ($user instanceof User) {
            $pagination = $declarationRepository->findByCitoyenPaginated($user, $page, $limit);
            $declarations = $pagination['items'];
            $totalDeclarations = $pagination['total'];
            $page = $pagination['page'];
            $pages = $pagination['pages'];

            // Compat integration: if a non-citizen account opens the citizen history
            // and has no personal records yet, show global declarations to keep data discoverable.
            if (0 === $totalDeclarations && $user->getType() !== User::TYPE_CITIZEN) {
                $declarations = $declarationRepository->findBy([], ['createdAt' => 'DESC'], $limit, ($page - 1) * $limit);
                $totalDeclarations = $declarationRepository->count([]);
                $pages = max(1, (int) ceil($totalDeclarations / $limit));
                $viewScope = 'all';
            }
        } else {
            $declarations = $declarationRepository->findBy([], ['createdAt' => 'DESC'], $limit, ($page - 1) * $limit);
            $totalDeclarations = $declarationRepository->count([]);
            $pages = max(1, (int) ceil($totalDeclarations / $limit));
            $viewScope = 'all';
        }

        return $this->render('citoyen/declarations.html.twig', [
            'declarations' => $declarations,
            'viewScope' => $viewScope,
            'pagination' => [
                'page' => $page,
                'pages' => $pages,
                'limit' => $limit,
                'total' => $totalDeclarations,
            ],
        ]);
    }

    #[Route('/citoyen/nouveautes', name: 'citoyen_nouveautes', methods: ['GET'])]
    public function nouveautes(NewsService $newsService): Response
    {
        $news = $newsService->getWasteAndEnergyNews(12);

        return $this->render('citoyen/nouveautes.html.twig', [
            'newsAvailable' => $news['available'],
            'newsMessage' => $news['message'],
            'articles' => $news['articles'],
        ]);
    }

    #[Route('/citoyen/air-quality', name: 'citoyen_air_quality', methods: ['GET'])]
    public function airQuality(): Response
    {
        return $this->render('citoyen/air_quality.html.twig', [
            'mapCenterLat' => 36.8065,
            'mapCenterLng' => 10.1815,
        ]);
    }

    #[Route('/citoyen/air-quality/data', name: 'citoyen_air_quality_data', methods: ['GET'])]
    public function airQualityData(OpenAqService $openAqService): JsonResponse
    {
        $lat = 36.8065;
        $lng = 10.1815;
        $result = $openAqService->getLocations($lat, $lng, 25000, 150);

        if (!$result['success']) {
            return $this->json([
                'success' => false,
                'message' => $result['message'] !== null ? $result['message'] : 'Impossible de charger les donnees de qualite d air.',
                'stations' => [],
            ], 503);
        }

        $stations = [];
        foreach ($result['results'] as $location) {
            $coordinates = $location['coordinates'] ?? null;
            $stationLat = null;
            $stationLng = null;

            if (is_array($coordinates)) {
                // Cas 1: coordinates['latitude'] / ['longitude']
                $stationLat = $coordinates['latitude'] ?? $coordinates['lat'] ?? null;
                $stationLng = $coordinates['longitude'] ?? $coordinates['lng'] ?? $coordinates['lon'] ?? null;

                // Cas 2: tableau numerique [lng, lat]
                if ((null === $stationLat || null === $stationLng) && isset($coordinates[0], $coordinates[1])) {
                    $stationLng = $coordinates[0];
                    $stationLat = $coordinates[1];
                }
            }

            // Cas 3: latitude / longitude au niveau racine.
            if (null === $stationLat || null === $stationLng) {
                $stationLat = $location['latitude'] ?? $stationLat;
                $stationLng = $location['longitude'] ?? $stationLng;
            }

            if (!is_numeric($stationLat) || !is_numeric($stationLng)) {
                continue;
            }

            $parameters = [];
            if (isset($location['sensors']) && is_array($location['sensors'])) {
                foreach ($location['sensors'] as $sensor) {
                    $parameterName = is_array($sensor) ? ($sensor['parameter']['name'] ?? null) : null;
                    if (is_string($parameterName) && '' !== trim($parameterName)) {
                        $parameters[] = $parameterName;
                    }
                }
            }

            $stations[] = [
                'name' => (string) ($location['name'] ?? 'Station'),
                'provider' => (string) ($location['providers'][0]['name'] ?? 'OpenAQ'),
                'latitude' => (float) $stationLat,
                'longitude' => (float) $stationLng,
                'parameters' => array_values(array_unique($parameters)),
            ];
        }

        return $this->json([
            'success' => true,
            'message' => null,
            'stations' => $stations,
        ]);
    }

    #[Route('/citoyen/withdraw', name: 'citoyen_withdraw', methods: ['GET', 'POST'])]
    public function withdraw(
        Request $request,
        UserRepository $userRepository,
        EcoPointsService $ecoPointsService,
        TransactionRepository $transactionRepository,
        StripeWithdrawService $stripeWithdrawService
    ): Response {
        $user = $this->resolveCurrentUser($userRepository);
        $pointsPerCurrency = 100;

        if (!$user instanceof User) {
            return $this->render('citoyen/withdraw.html.twig', [
                'wallet' => null,
                'pointsPerCurrency' => $pointsPerCurrency,
                'estimatedMoney' => 0.0,
                'maxWithdrawPoints' => 0,
                'recentWithdraws' => [],
                'stripeEnabled' => $stripeWithdrawService->isEnabled(),
                'stripeConnected' => false,
                'payoutCurrency' => $stripeWithdrawService->getPayoutCurrency(),
            ]);
        }

        $wallet = $ecoPointsService->getOrCreateWallet($user);
        $maxWithdrawPoints = max(0, (int) $wallet->getSoldeActuel());
        $stripeEnabled = $stripeWithdrawService->isEnabled();
        $stripeConnected = $stripeWithdrawService->isConnected($user);

        if ($request->isMethod('POST')) {
            $csrfToken = (string) $request->request->get('_token', '');
            if (!$this->isCsrfTokenValid('citoyen_withdraw', $csrfToken)) {
                $this->addFlash('error', 'Token CSRF invalide.');

                return $this->redirectToRoute('citoyen_withdraw');
            }

            $pointsRaw = trim((string) $request->request->get('points', ''));
            $pointsToWithdraw = ctype_digit($pointsRaw) ? (int) $pointsRaw : 0;

            if ($pointsToWithdraw <= 0) {
                $this->addFlash('error', 'Veuillez saisir un montant de points valide.');
            } elseif ($pointsToWithdraw > $maxWithdrawPoints) {
                $this->addFlash('error', 'Le montant demande depasse votre solde disponible.');
            } elseif (!$stripeEnabled) {
                $this->addFlash('error', 'Le service de retrait Stripe est indisponible.');
            } elseif (!$stripeConnected) {
                $this->addFlash('error', 'Veuillez connecter votre compte Stripe avant de demander un retrait.');
            } else {
                try {
                    $amountMoney = $pointsToWithdraw / $pointsPerCurrency;
                    $amountMinor = (int) round($amountMoney * 100);
                    if ($amountMinor <= 0) {
                        $this->addFlash('error', 'Montant de retrait invalide.');

                        return $this->redirectToRoute('citoyen_withdraw');
                    }

                    $payoutResult = $stripeWithdrawService->createPayout(
                        $user,
                        $amountMinor,
                        sprintf('Retrait WasteWise de %.2f', $amountMoney)
                    );
                    if (!($payoutResult['success'] ?? false)) {
                        $error = $payoutResult['error'] ?? null;
                        $this->addFlash('error', is_string($error) ? $error : 'Echec payout Stripe.');

                        return $this->redirectToRoute('citoyen_withdraw');
                    }

                    $payoutId = $payoutResult['payout_id'] ?? null;
                    $safePayoutId = is_string($payoutId) ? $payoutId : '-';
                    $ecoPointsService->spendPoints(
                        $user,
                        $pointsToWithdraw,
                        sprintf(
                            'Retrait Stripe #%s: %d points convertis en %.2f',
                            $safePayoutId,
                            $pointsToWithdraw,
                            $amountMoney
                        )
                    );

                    $this->addFlash(
                        'success',
                        sprintf(
                            'Retrait valide vers carte bancaire: %d points convertis en %.2f %s.',
                            $pointsToWithdraw,
                            $amountMoney,
                            $stripeWithdrawService->getPayoutCurrency()
                        )
                    );

                    return $this->redirectToRoute('citoyen_withdraw');
                } catch (\RuntimeException $exception) {
                    $this->addFlash('error', $exception->getMessage());
                }
            }
        }

        $estimatedMoney = $wallet->getSoldeActuel() / $pointsPerCurrency;
        $recentWithdraws = array_values(array_filter(
            $transactionRepository->getLastTransactionsByUser($user, 20),
            static fn ($transaction): bool => 'Depense' === $transaction->getType()
        ));

        return $this->render('citoyen/withdraw.html.twig', [
            'wallet' => $wallet,
            'pointsPerCurrency' => $pointsPerCurrency,
            'estimatedMoney' => $estimatedMoney,
            'maxWithdrawPoints' => $maxWithdrawPoints,
            'recentWithdraws' => $recentWithdraws,
            'stripeEnabled' => $stripeEnabled,
            'stripeConnected' => $stripeConnected,
            'payoutCurrency' => $stripeWithdrawService->getPayoutCurrency(),
        ]);
    }

    #[Route('/citoyen/withdraw/connect-stripe', name: 'citoyen_withdraw_connect_stripe', methods: ['GET'])]
    public function connectStripeWithdraw(
        UserRepository $userRepository,
        StripeWithdrawService $stripeWithdrawService
    ): Response {
        $user = $this->resolveCurrentUser($userRepository);
        if (!$user instanceof User) {
            $this->addFlash('error', 'Utilisateur introuvable.');

            return $this->redirectToRoute('citoyen_withdraw');
        }

        $result = $stripeWithdrawService->createOnboardingLink($user);
        if (!($result['success'] ?? false)) {
            $error = $result['error'] ?? null;
            $this->addFlash('error', is_string($error) ? $error : 'Impossible de connecter Stripe.');

            return $this->redirectToRoute('citoyen_withdraw');
        }

        $url = $result['url'] ?? null;

        return $this->redirect(is_string($url) ? $url : $this->generateUrl('citoyen_withdraw'));
    }

    #[Route('/citoyen/statistiques', name: 'citoyen_statistiques')]
    public function statistiques(
        DeclarationDechetRepository $declarationRepository,
        TransactionRepository $transactionRepository,
        EcoPointsService $ecoPointsService,
        UserRepository $userRepository,
        WalletRepository $walletRepository
    ): Response {
        $user = $this->resolveCurrentUser($userRepository);
        $viewScope = 'mine';
        $soldeActuel = 0;

        if (!$user instanceof User) {
            $viewScope = 'all';
            return $this->render('citoyen/statistiques.html.twig', [
                'wallet' => null,
                'soldeActuel' => $walletRepository->getTotalSolde(),
                'totalApprouvees' => $declarationRepository->count([
                    'statut' => DeclarationDechet::STATUT_APPROUVEE,
                    'deletedAt' => null,
                ]),
                'totalGains' => $transactionRepository->getTotalGains(),
                'totalDepenses' => $transactionRepository->getTotalDepenses(),
                'transactionsCount' => $transactionRepository->countAll(),
                'transactions' => $transactionRepository->getLastTransactions(20),
                'viewScope' => $viewScope,
            ]);
        }

        $wallet = $ecoPointsService->getOrCreateWallet($user);
        $soldeActuel = (int) $wallet->getSoldeActuel();
        $totalApprouvees = $declarationRepository->countApprovedByCitoyen($user);
        $totalGains = $transactionRepository->getTotalGainsByUser($user);
        $totalDepenses = $transactionRepository->getTotalDepensesByUser($user);
        $transactionsCount = $transactionRepository->countByUser($user);
        $transactions = $transactionRepository->getLastTransactionsByUser($user, 20);

        if ($user->getType() !== User::TYPE_CITIZEN && 0 === $totalApprouvees && 0 === $transactionsCount && 0 === $soldeActuel) {
            $viewScope = 'all';
            $soldeActuel = $walletRepository->getTotalSolde();
            $totalApprouvees = $declarationRepository->count([
                'statut' => DeclarationDechet::STATUT_APPROUVEE,
                'deletedAt' => null,
            ]);
            $totalGains = $transactionRepository->getTotalGains();
            $totalDepenses = $transactionRepository->getTotalDepenses();
            $transactionsCount = $transactionRepository->countAll();
            $transactions = $transactionRepository->getLastTransactions(20);
        }

        return $this->render('citoyen/statistiques.html.twig', [
            'wallet' => $wallet,
            'soldeActuel' => $soldeActuel,
            'totalApprouvees' => $totalApprouvees,
            'totalGains' => $totalGains,
            'totalDepenses' => $totalDepenses,
            'transactionsCount' => $transactionsCount,
            'transactions' => $transactions,
            'viewScope' => $viewScope,
        ]);
    }

    #[Route('/citoyen/parametres', name: 'citoyen_parametres')]
    public function parametres(): Response
    {
        return $this->render('citoyen/parametres.html.twig');
    }

    private function resolveCurrentUser(UserRepository $userRepository): ?User
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
}
