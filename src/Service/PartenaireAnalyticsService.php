<?php

namespace App\Service;

use App\Entity\BadgePartenaire;
use App\Entity\BonAchat;
use App\Entity\DeclarationDechet;
use App\Entity\User;
use App\Repository\BadgePartenaireRepository;
use App\Repository\BonAchatRepository;
use App\Repository\DeclarationDechetRepository;
use Doctrine\ORM\EntityManagerInterface;

class PartenaireAnalyticsService
{
    public function __construct(
        private readonly BonAchatRepository $bonAchatRepository,
        private readonly BadgePartenaireRepository $badgePartenaireRepository,
        private readonly DeclarationDechetRepository $declarationDechetRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return array{
     *     kpis: array<string, mixed>,
     *     badge: array<string, mixed>,
     *     ranking: array<int, array<string, mixed>>,
     *     expiringVouchers: array<int, BonAchat>,
     *     storePerformance: array<int, array<string, mixed>>,
     *     monthlyDistributed: array<string, array<int, mixed>>,
     *     impactGlobal: array<string, mixed>
     * }
     */
    public function buildDashboardPayload(User $partenaire): array
    {
        $this->refreshVoucherStatuses($partenaire);

        $kpis = $this->bonAchatRepository->getPartnerKpis($partenaire);
        $impactScore = $this->computeImpactScore($partenaire, $kpis);
        $badge = $this->syncBadgeForPartner($partenaire, $kpis, $impactScore);
        $impact = $this->getGlobalImpactPayload();
        $partnerCo2 = round(($kpis['used'] * 0.28) + ($kpis['distributedValue'] * 0.015), 2);
        $partnerEnvironmentalImpact = round($partnerCo2 + ($impact['co2Avoided'] * min(0.15, $kpis['total'] / 300)), 2);

        return [
            'kpis' => [
                'totalVouchers' => $kpis['total'],
                'activeVouchers' => $kpis['active'],
                'usedVouchers' => $kpis['used'],
                'distributedValue' => round($kpis['distributedValue'], 2),
                'estimatedCo2Reduction' => $partnerCo2,
                'currentBadge' => $badge['nom'],
                'globalEnvironmentalImpact' => $partnerEnvironmentalImpact,
                'impactScore' => $impactScore,
                'expiringSoon' => $kpis['expiringSoon'],
            ],
            'badge' => $badge,
            'ranking' => $this->bonAchatRepository->getImpactRanking(10),
            'expiringVouchers' => $this->bonAchatRepository->findExpiringSoon($partenaire),
            'storePerformance' => $this->bonAchatRepository->getStorePerformance($partenaire),
            'monthlyDistributed' => $this->bonAchatRepository->getMonthlyDistributedValue($partenaire),
            'impactGlobal' => $impact,
        ];
    }

    /**
     * @return array{
     *     totalCollected: float,
     *     totalValued: float,
     *     totalEcoPoints: int,
     *     co2Avoided: float,
     *     byType: array<int, array{label: string, quantity: float}>
     * }
     */
    public function getGlobalImpactPayload(): array
    {
        $totalCollected = (float) $this->declarationDechetRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.deletedAt IS NULL')
            ->getQuery()
            ->getSingleScalarResult();

        $totalValued = (float) $this->declarationDechetRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.quantite), 0)')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $totalEcoPoints = (int) $this->declarationDechetRepository->createQueryBuilder('d')
            ->select('COALESCE(SUM(d.pointsAttribues), 0)')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();

        $rows = $this->declarationDechetRepository->createQueryBuilder('d')
            ->select('COALESCE(t.libelle, :fallback) AS label')
            ->addSelect('COALESCE(SUM(d.quantite), 0) AS quantity')
            ->leftJoin('d.typeDechet', 't')
            ->where('d.deletedAt IS NULL')
            ->groupBy('t.id, t.libelle')
            ->setParameter('fallback', 'Non defini')
            ->orderBy('quantity', 'DESC')
            ->getQuery()
            ->getArrayResult();

        return [
            'totalCollected' => round($totalCollected, 2),
            'totalValued' => round($totalValued, 2),
            'totalEcoPoints' => $totalEcoPoints,
            'co2Avoided' => round($totalValued * 1.3727, 2),
            'byType' => array_map(static function (array $row): array {
                return [
                    'label' => (string) ($row['label'] ?? 'Non defini'),
                    'quantity' => round((float) ($row['quantity'] ?? 0), 2),
                ];
            }, $rows),
        ];
    }

    /**
     * @return array<int, array{
     *     lat: float,
     *     lng: float,
     *     total: int,
     *     approved: int,
     *     pending: int,
     *     refused: int,
     *     zoneStatus: string,
     *     color: string
     * }>
     */
    public function getHeatmapZones(?\DateTimeInterface $from = null, ?\DateTimeInterface $to = null): array
    {
        $qb = $this->declarationDechetRepository->createQueryBuilder('d')
            ->select('d.latitude AS lat, d.longitude AS lng, d.statut AS statut')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.latitude IS NOT NULL')
            ->andWhere('d.longitude IS NOT NULL')
            ->setMaxResults(3000);

        if ($from instanceof \DateTimeInterface) {
            $qb->andWhere('d.createdAt >= :from')
                ->setParameter('from', $from);
        }
        if ($to instanceof \DateTimeInterface) {
            $qb->andWhere('d.createdAt <= :to')
                ->setParameter('to', $to);
        }

        $rows = $qb->getQuery()->getArrayResult();
        $zones = [];
        foreach ($rows as $row) {
            $lat = round((float) ($row['lat'] ?? 0), 2);
            $lng = round((float) ($row['lng'] ?? 0), 2);
            $key = $lat.'|'.$lng;
            if (!isset($zones[$key])) {
                $zones[$key] = [
                    'lat' => $lat,
                    'lng' => $lng,
                    'total' => 0,
                    'approved' => 0,
                    'pending' => 0,
                    'refused' => 0,
                ];
            }

            ++$zones[$key]['total'];
            $status = (string) ($row['statut'] ?? '');
            if ($status === DeclarationDechet::STATUT_APPROUVEE) {
                ++$zones[$key]['approved'];
            } elseif ($status === DeclarationDechet::STATUT_EN_ATTENTE) {
                ++$zones[$key]['pending'];
            } else {
                ++$zones[$key]['refused'];
            }
        }

        $formatted = [];
        foreach ($zones as $zone) {
            $zoneStatus = 'VERTE';
            $color = '#1f9d55';

            if ($zone['pending'] > $zone['approved']) {
                $zoneStatus = 'ORANGE';
                $color = '#f59e0b';
            }
            if ($zone['refused'] > $zone['approved'] && $zone['refused'] >= $zone['pending']) {
                $zoneStatus = 'ROUGE';
                $color = '#dc2626';
            }

            $formatted[] = array_merge($zone, [
                'zoneStatus' => $zoneStatus,
                'color' => $color,
            ]);
        }

        usort($formatted, static fn (array $a, array $b): int => (int) (($b['total'] ?? 0) <=> ($a['total'] ?? 0)));

        return array_slice($formatted, 0, 120);
    }

    /**
     * @return array<int, DeclarationDechet>
     */
    public function getReadOnlyDeclarations(int $limit = 120): array
    {
        return $this->declarationDechetRepository->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->where('d.deletedAt IS NULL')
            ->orderBy('d.createdAt', 'DESC')
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int, DeclarationDechet>
     */
    public function getReadOnlyValorisation(int $limit = 120): array
    {
        return $this->declarationDechetRepository->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->addSelect('v')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.statut = :approved')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->orderBy('d.dateConfirmation', 'DESC')
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array{
     *     from: ?\DateTimeInterface,
     *     to: ?\DateTimeInterface,
     *     vouchers: array<int, BonAchat>,
     *     totals: array<string, float|int>,
     *     signature: string
     * }
     */
    public function buildFiscalReportPayload(User $partenaire, ?\DateTimeInterface $from, ?\DateTimeInterface $to): array
    {
        $vouchers = $this->bonAchatRepository->findForFiscalPeriod($partenaire, $from, $to);
        $totalValue = 0.0;
        $totalUsed = 0;
        $totalEstimatedContribution = 0.0;

        foreach ($vouchers as $voucher) {
            $used = $voucher->getNombreUtilisations();
            $distributed = $used * $voucher->getValeurMonetaire();
            $totalUsed += $used;
            $totalValue += $distributed;
            $totalEstimatedContribution += ($used * 0.28) + ($distributed * 0.015);
        }

        return [
            'from' => $from,
            'to' => $to,
            'vouchers' => $vouchers,
            'totals' => [
                'proposed' => count($vouchers),
                'used' => $totalUsed,
                'distributedValue' => round($totalValue, 2),
                'environmentContribution' => round($totalEstimatedContribution, 2),
            ],
            'signature' => $this->generatePlatformSignature($partenaire, $from, $to, $totalValue, $totalUsed),
        ];
    }

    private function refreshVoucherStatuses(User $partenaire): void
    {
        $vouchers = $this->bonAchatRepository->findByPartenaireOrdered($partenaire);
        $updated = false;
        $now = new \DateTimeImmutable('today');

        foreach ($vouchers as $voucher) {
            $previous = $voucher->getStatut();
            $voucher->refreshStatut($now);
            if ($previous !== $voucher->getStatut()) {
                $voucher->setUpdatedAt(new \DateTimeImmutable());
                $updated = true;
            }
        }

        if ($updated) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param array<string, float|int> $kpis
     */
    private function computeImpactScore(User $partenaire, array $kpis): int
    {
        $sensitiveParticipation = (int) $this->bonAchatRepository->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->where('b.partenaire = :partenaire')
            ->andWhere('b.zoneGeographique IS NOT NULL')
            ->andWhere('b.zoneGeographique != :empty')
            ->setParameter('partenaire', $partenaire)
            ->setParameter('empty', '')
            ->getQuery()
            ->getSingleScalarResult();

        $score =
            ((int) ($kpis['total'] ?? 0) * 3) +
            ((int) ($kpis['used'] ?? 0) * 5) +
            (int) round(((float) ($kpis['distributedValue'] ?? 0)) * 0.8) +
            ($sensitiveParticipation * 8);

        return max(0, min(1000, $score));
    }

    /**
     * @param array<string, float|int> $kpis
     * @return array{code: string, nom: string, description: string, icone: string, couleur: string, scoreImpact: int}
     */
    private function syncBadgeForPartner(User $partenaire, array $kpis, int $impactScore): array
    {
        $definition = $this->resolveBadgeDefinition(
            (int) ($kpis['total'] ?? 0),
            (float) ($kpis['distributedValue'] ?? 0),
            $impactScore
        );

        $current = $this->badgePartenaireRepository->findCurrentBadge($partenaire);
        if ($current instanceof BadgePartenaire && $current->getCode() === $definition['code']) {
            $current->setScoreImpact($impactScore);
            $current->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->flush();

            return $definition;
        }

        $this->badgePartenaireRepository->setAllAsNotCurrent($partenaire);

        $badge = (new BadgePartenaire())
            ->setPartenaire($partenaire)
            ->setCode($definition['code'])
            ->setNom($definition['nom'])
            ->setDescription($definition['description'])
            ->setIcone($definition['icone'])
            ->setCouleur($definition['couleur'])
            ->setScoreImpact($impactScore)
            ->setIsCurrent(true)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($badge);
        $this->entityManager->flush();

        return $definition;
    }

    /**
     * @return array{code: string, nom: string, description: string, icone: string, couleur: string, scoreImpact: int}
     */
    private function resolveBadgeDefinition(int $totalVouchers, float $distributedValue, int $impactScore): array
    {
        if ($totalVouchers >= 20 && $distributedValue >= 1200 && $impactScore >= 420) {
            return [
                'code' => 'PARTENAIRE_PREMIUM',
                'nom' => 'Partenaire Premium',
                'description' => 'Performance business et impact eleves.',
                'icone' => 'fa-gem',
                'couleur' => '#0ea5a4',
                'scoreImpact' => $impactScore,
            ];
        }

        if ($totalVouchers >= 12 && $distributedValue >= 500 && $impactScore >= 230) {
            return [
                'code' => 'ECO_LEADER',
                'nom' => 'Eco Leader',
                'description' => 'Pilotage exemplaire des bons et de l impact.',
                'icone' => 'fa-trophy',
                'couleur' => '#f59e0b',
                'scoreImpact' => $impactScore,
            ];
        }

        if ($totalVouchers >= 5 || $distributedValue >= 150 || $impactScore >= 120) {
            return [
                'code' => 'IMPACT_DURABLE',
                'nom' => 'Impact Durable',
                'description' => 'Contribution reguliere aux objectifs durables.',
                'icone' => 'fa-earth-africa',
                'couleur' => '#1d4ed8',
                'scoreImpact' => $impactScore,
            ];
        }

        return [
            'code' => 'PARTENAIRE_VERT',
            'nom' => 'Partenaire Vert',
            'description' => 'Engagement initial valide sur la plateforme.',
            'icone' => 'fa-seedling',
            'couleur' => '#16a34a',
            'scoreImpact' => $impactScore,
        ];
    }

    private function generatePlatformSignature(
        User $partenaire,
        ?\DateTimeInterface $from,
        ?\DateTimeInterface $to,
        float $totalValue,
        int $totalUsed
    ): string {
        $identity = sprintf(
            '%s|%s|%s|%s|%.2f|%d|%s',
            $partenaire->getId(),
            $partenaire->getEmail(),
            $from?->format('Y-m-d') ?? '-',
            $to?->format('Y-m-d') ?? '-',
            $totalValue,
            $totalUsed,
            (new \DateTimeImmutable())->format('Ymd')
        );

        return strtoupper(substr(sha1($identity), 0, 24));
    }
}
