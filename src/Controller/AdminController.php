<?php

namespace App\Controller;

use App\Entity\DeclarationDechet;
use App\Entity\User;
use App\Service\WeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(EntityManagerInterface $entityManager, WeatherService $weatherService): Response
    {
        $declarationRepo = $entityManager->getRepository(DeclarationDechet::class);
        $userRepo = $entityManager->getRepository(User::class);

        $totalUsers = (int) $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalDeclarations = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalApproved = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $totalPending = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.statut = :pending')
            ->setParameter('pending', DeclarationDechet::STATUT_EN_ATTENTE)
            ->getQuery()
            ->getSingleScalarResult();

        $totalKgRecycles = (float) $declarationRepo->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $totalEcoPoints = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.pointsAttribues), 0)')
            ->where('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $totalBonsEmis = 0;
        $globalValorisationRate = $totalDeclarations > 0 ? round(($totalApproved / $totalDeclarations) * 100, 1) : 0;

        $today = new \DateTimeImmutable('today');
        $firstDayOfMonth = new \DateTimeImmutable('first day of this month midnight');

        $declarationsToday = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.createdAt = :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult();

        $highActivity = $declarationsToday >= 3 || $totalPending > 20;
        $dynamicSubtitle = $highActivity
            ? 'Plateforme en forte activite aujourd hui.'
            : 'Activite moderee, surveillez les validations.';

        $totalCitoyens = (int) $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_CITOYEN%')
            ->getQuery()
            ->getSingleScalarResult();

        if (0 === $totalCitoyens) {
            $totalCitoyens = (int) $declarationRepo->createQueryBuilder('d')
                ->select('COUNT(DISTINCT d.citoyen)')
                ->where('d.citoyen IS NOT NULL')
                ->getQuery()
                ->getSingleScalarResult();
        }

        $newCitoyensThisMonth = (int) $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->andWhere('u.dateInscription >= :monthStart')
            ->setParameter('role', '%ROLE_CITOYEN%')
            ->setParameter('monthStart', $firstDayOfMonth)
            ->getQuery()
            ->getSingleScalarResult();

        if (0 === $newCitoyensThisMonth) {
            $newCitoyensThisMonth = (int) $declarationRepo->createQueryBuilder('d')
                ->select('COUNT(DISTINCT d.citoyen)')
                ->where('d.citoyen IS NOT NULL')
                ->andWhere('d.createdAt >= :monthStart')
                ->setParameter('monthStart', $firstDayOfMonth->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();
        }

        $totalCitizenDeclarations = (int) $declarationRepo->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.citoyen IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();

        $citizenKgTotal = (float) $declarationRepo->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.citoyen IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();

        $avgKgPerCitizen = $totalCitoyens > 0 ? round($citizenKgTotal / $totalCitoyens, 2) : 0;

        $topCitizenRows = $declarationRepo->createQueryBuilder('d')
            ->select('c.prenom AS prenom, c.nom AS nom, c.email AS email, COALESCE(SUM(d.pointsAttribues), 0) AS points')
            ->leftJoin('d.citoyen', 'c')
            ->where('d.citoyen IS NOT NULL')
            ->groupBy('c.id, c.prenom, c.nom, c.email')
            ->orderBy('points', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult();

        $topCitoyens = array_map(static function (array $row): array {
            return [
                'name' => trim((string) (($row['prenom'] ?? '').' '.($row['nom'] ?? ''))),
                'email' => (string) ($row['email'] ?? '-'),
                'points' => (int) ($row['points'] ?? 0),
            ];
        }, $topCitizenRows);

        $totalValorisateursActifs = (int) $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_VALORISATEUR%')
            ->getQuery()
            ->getSingleScalarResult();

        $kgValorisesThisMonth = (float) $declarationRepo->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.statut = :approved')
            ->andWhere('d.createdAt >= :monthStart')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->setParameter('monthStart', $firstDayOfMonth->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult();

        $averageValidationRate = $globalValorisationRate;

        $bestValorisateurRow = $userRepo->createQueryBuilder('u')
            ->select('u.prenom AS prenom, u.nom AS nom, u.capaciteMaxJournaliere AS capacite')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_VALORISATEUR%')
            ->orderBy('u.capaciteMaxJournaliere', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        $bestValorisateur = $bestValorisateurRow
            ? trim((string) (($bestValorisateurRow['prenom'] ?? '').' '.($bestValorisateurRow['nom'] ?? '')))
            : 'Non disponible';
        $bestValorisateurCapacite = (int) ($bestValorisateurRow['capacite'] ?? 0);

        $totalPartenaires = (int) $userRepo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_PARTENAIRE%')
            ->getQuery()
            ->getSingleScalarResult();

        $totalBonsCrees = 0;
        $totalBonsUtilises = 0;
        $valeurRecompensesDistribuees = 0;
        $partenaireMostActif = 'Non disponible';

        $co2Economise = round($totalKgRecycles * 1.3727, 0);
        $arbresSauves = round($co2Economise / 21, 2);
        $eauEconomisee = round($totalKgRecycles * 30.82, 0);
        $voituresRetirees = round($co2Economise / 4300, 2);

        $connection = $entityManager->getConnection();

        $citizenMonthlyRows = $connection->fetchAllAssociative("
            SELECT DATE_FORMAT(created_at, '%m/%Y') AS label, COUNT(*) AS total
            FROM declaration_dechet
            WHERE citoyen_id IS NOT NULL
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ");

        $citizenMonthlyLabels = array_map(static fn (array $row): string => (string) ($row['label'] ?? ''), $citizenMonthlyRows);
        $citizenMonthlyData = array_map(static fn (array $row): int => (int) ($row['total'] ?? 0), $citizenMonthlyRows);

        $dechetPieRows = $declarationRepo->createQueryBuilder('d')
            ->select('t.libelle AS label, COALESCE(SUM(d.quantite), 0) AS total')
            ->leftJoin('d.typeDechet', 't')
            ->where('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->groupBy('t.id, t.libelle')
            ->getQuery()
            ->getArrayResult();

        $dechetPieLabels = [];
        $dechetPieData = [];
        foreach ($dechetPieRows as $row) {
            $dechetPieLabels[] = (string) ($row['label'] ?? 'Non defini');
            $dechetPieData[] = (float) ($row['total'] ?? 0);
        }

        $userGrowthRows = $connection->fetchAllAssociative("
            SELECT DATE_FORMAT(date_inscription, '%Y-%m') AS bucket, COUNT(*) AS total
            FROM `user`
            WHERE date_inscription IS NOT NULL
            GROUP BY YEAR(date_inscription), MONTH(date_inscription)
            ORDER BY YEAR(date_inscription), MONTH(date_inscription)
        ");

        $kgGrowthRows = $connection->fetchAllAssociative("
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS bucket, COALESCE(SUM(quantite), 0) AS total
            FROM declaration_dechet
            WHERE statut = :approved
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ", ['approved' => DeclarationDechet::STATUT_APPROUVEE]);

        // Fenetre dynamique glissante sur 6 mois pour eviter des courbes ecrasees par l'historique ancien.
        $months = [];
        $currentMonth = new \DateTimeImmutable('first day of this month');
        for ($i = 5; $i >= 0; --$i) {
            $months[] = $currentMonth->modify(sprintf('-%d month', $i))->format('Y-m');
        }

        $userByMonth = [];
        foreach ($userGrowthRows as $row) {
            $bucket = (string) ($row['bucket'] ?? '');
            if ('' !== $bucket) {
                $userByMonth[$bucket] = (int) ($row['total'] ?? 0);
            }
        }

        $kgByMonth = [];
        foreach ($kgGrowthRows as $row) {
            $bucket = (string) ($row['bucket'] ?? '');
            if ('' !== $bucket) {
                $kgByMonth[$bucket] = (float) ($row['total'] ?? 0);
            }
        }

        $userGrowthLabels = array_map(static function (string $bucket): string {
            [$y, $m] = explode('-', $bucket);
            return sprintf('%02d/%s', (int) $m, $y);
        }, $months);
        $userGrowthData = array_map(static fn (string $bucket): int => (int) ($userByMonth[$bucket] ?? 0), $months);
        $kgGrowthLabels = $userGrowthLabels;
        $kgGrowthData = array_map(static fn (string $bucket): float => (float) ($kgByMonth[$bucket] ?? 0), $months);

        $currentUsers = (int) ($userGrowthData[5] ?? 0);
        $previousUsers = (int) ($userGrowthData[4] ?? 0);
        $userGrowthPct = $previousUsers > 0
            ? round((($currentUsers - $previousUsers) / $previousUsers) * 100, 1)
            : ($currentUsers > 0 ? 100.0 : 0.0);

        $currentKg = (float) ($kgGrowthData[5] ?? 0.0);
        $previousKg = (float) ($kgGrowthData[4] ?? 0.0);
        $kgGrowthPct = $previousKg > 0
            ? round((($currentKg - $previousKg) / $previousKg) * 100, 1)
            : ($currentKg > 0 ? 100.0 : 0.0);

        $ecoPointsRows = $connection->fetchAllAssociative("
            SELECT DATE_FORMAT(created_at, '%m/%Y') AS label, COALESCE(SUM(points_attribues), 0) AS total
            FROM declaration_dechet
            WHERE statut = :approved
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ", ['approved' => DeclarationDechet::STATUT_APPROUVEE]);

        $ecoPointsLabels = array_map(static fn (array $row): string => (string) ($row['label'] ?? ''), $ecoPointsRows);
        $ecoPointsData = array_map(static fn (array $row): int => (int) ($row['total'] ?? 0), $ecoPointsRows);

        $bonsPartnerLabels = $totalPartenaires > 0 ? ['Partenaires'] : [];
        $bonsPartnerData = $totalPartenaires > 0 ? [$totalBonsUtilises] : [];

        $lastActivityDate = $declarationRepo->createQueryBuilder('d')
            ->select('MAX(d.createdAt)')
            ->getQuery()
            ->getSingleScalarResult();

        $lastActivity = $lastActivityDate
            ? (new \DateTime((string) $lastActivityDate))->format('d/m/Y H:i')
            : '-';

        $connectionsToday = 0;

        $rolesActivity = [
            'Citoyens' => $totalCitoyens,
            'Valorisateurs' => $totalValorisateursActifs,
            'Partenaires' => $totalPartenaires,
        ];
        arsort($rolesActivity);
        $mostActiveRole = (string) array_key_first($rolesActivity);

        $firstDeclarationDate = $declarationRepo->createQueryBuilder('d')
            ->select('MIN(d.createdAt)')
            ->where('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $averageValidationMinutes = 0;
        if ($totalApproved > 0 && $firstDeclarationDate) {
            $first = new \DateTime((string) $firstDeclarationDate);
            $now = new \DateTime();
            $minutes = max(0, (int) floor(($now->getTimestamp() - $first->getTimestamp()) / 60));
            $averageValidationMinutes = (int) round($minutes / $totalApproved);
        }

        return $this->render('admin/dashboard.html.twig', [
            'weather' => $weatherService->getCurrentWeather(),
            'dynamicSubtitle' => $dynamicSubtitle,
            'totalUsers' => $totalUsers,
            'totalDeclarations' => $totalDeclarations,
            'totalKgRecycles' => $totalKgRecycles,
            'totalEcoPoints' => $totalEcoPoints,
            'totalBonsEmis' => $totalBonsEmis,
            'globalValorisationRate' => $globalValorisationRate,
            'totalCitoyens' => $totalCitoyens,
            'newCitoyensThisMonth' => $newCitoyensThisMonth,
            'totalCitizenDeclarations' => $totalCitizenDeclarations,
            'avgKgPerCitizen' => $avgKgPerCitizen,
            'topCitoyens' => $topCitoyens,
            'totalValorisateursActifs' => $totalValorisateursActifs,
            'kgValorisesThisMonth' => $kgValorisesThisMonth,
            'averageValidationRate' => $averageValidationRate,
            'pendingDeclarations' => $totalPending,
            'bestValorisateur' => $bestValorisateur,
            'bestValorisateurCapacite' => $bestValorisateurCapacite,
            'totalPartenaires' => $totalPartenaires,
            'totalBonsCrees' => $totalBonsCrees,
            'totalBonsUtilises' => $totalBonsUtilises,
            'valeurRecompensesDistribuees' => $valeurRecompensesDistribuees,
            'partenaireMostActif' => $partenaireMostActif,
            'co2Economise' => $co2Economise,
            'arbresSauves' => $arbresSauves,
            'eauEconomisee' => $eauEconomisee,
            'voituresRetirees' => $voituresRetirees,
            'citizenMonthlyLabels' => $citizenMonthlyLabels,
            'citizenMonthlyData' => $citizenMonthlyData,
            'dechetPieLabels' => $dechetPieLabels,
            'dechetPieData' => $dechetPieData,
            'userGrowthLabels' => $userGrowthLabels,
            'userGrowthData' => $userGrowthData,
            'userGrowthPct' => $userGrowthPct,
            'kgGrowthLabels' => $kgGrowthLabels,
            'kgGrowthData' => $kgGrowthData,
            'kgGrowthPct' => $kgGrowthPct,
            'ecoPointsLabels' => $ecoPointsLabels,
            'ecoPointsData' => $ecoPointsData,
            'bonsPartnerLabels' => $bonsPartnerLabels,
            'bonsPartnerData' => $bonsPartnerData,
            'lastActivity' => $lastActivity,
            'connectionsToday' => $connectionsToday,
            'mostActiveRole' => $mostActiveRole,
            'averageValidationMinutes' => $averageValidationMinutes,
            'showPendingAlert' => $totalPending > 20,
            'showNoPartnerAlert' => $totalPartenaires === 0,
            'showHighActivityBadge' => $highActivity,
        ]);
    }

    #[Route('/admin/declarations/legacy', name: 'admin_declarations_legacy')]
    public function declarationsLegacy(): Response
    {
        return $this->redirectToRoute('admin_declarations');
    }

    #[Route('/admin/utilisateurs', name: 'admin_utilisateurs')]
    public function utilisateurs(): Response
    {
        return $this->render('admin/utilisateurs.html.twig');
    }
}
