<?php

namespace App\Repository;

use App\Entity\DeclarationDechet;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeclarationDechet>
 */
class DeclarationDechetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeclarationDechet::class);
    }

    /**
     * @return DeclarationDechet[]
     */
    public function findPendingOrderedDesc(): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.statut = :pending')
            ->andWhere('d.deletedAt IS NULL')
            ->setParameter('pending', DeclarationDechet::STATUT_EN_ATTENTE)
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countApprovedByCitoyen(User $citoyen): int
    {
        return (int) $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.citoyen = :citoyen')
            ->andWhere('d.statut = :approved')
            ->andWhere('d.deletedAt IS NULL')
            ->setParameter('citoyen', $citoyen)
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return array{items: array<int, DeclarationDechet>, total: int, page: int, pages: int}
     */
    public function findAdminDeclarations(array $filters, int $page = 1, int $limit = 10): array
    {
        $page = max(1, $page);
        $limit = max(1, $limit);

        $listQb = $this->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->addSelect('v')
            ->andWhere('d.deletedAt IS NULL');

        $this->applyAdminFilters($listQb, $filters);

        $sortDirection = strtoupper((string) ($filters['sort'] ?? 'DESC'));
        if (!\in_array($sortDirection, ['ASC', 'DESC'], true)) {
            $sortDirection = 'DESC';
        }

        $listQb
            ->orderBy('d.createdAt', $sortDirection)
            ->addOrderBy('d.id', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $items = $listQb->getQuery()->getResult();

        $countQb = $this->createQueryBuilder('d')
            ->select('COUNT(DISTINCT d.id)')
            ->leftJoin('d.citoyen', 'c')
            ->leftJoin('d.typeDechet', 't')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->andWhere('d.deletedAt IS NULL');

        $this->applyAdminFilters($countQb, $filters);

        $total = (int) $countQb->getQuery()->getSingleScalarResult();
        $pages = max(1, (int) ceil($total / $limit));

        if ($page > $pages) {
            return $this->findAdminDeclarations($filters, $pages, $limit);
        }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
        ];
    }

    /**
     * @return DeclarationDechet[]
     */
    public function findAdminDeclarationsForExport(array $filters, int $limit = 5000): array
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->addSelect('v')
            ->andWhere('d.deletedAt IS NULL');

        $this->applyAdminFilters($qb, $filters);

        return $qb
            ->orderBy('d.createdAt', 'DESC')
            ->addOrderBy('d.id', 'DESC')
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array{
     *     types: array<int, array{id: int, label: string, total: int}>,
     *     valorisateurs: array<int, array{id: int, label: string, total: int}>
     * }
     */
    public function getAdminFilterOptions(): array
    {
        $typeRows = $this->createQueryBuilder('d')
            ->select('t.id AS id, t.libelle AS label, COUNT(d.id) AS total')
            ->leftJoin('d.typeDechet', 't')
            ->where('d.deletedAt IS NULL')
            ->andWhere('t.id IS NOT NULL')
            ->groupBy('t.id, t.libelle')
            ->orderBy('t.libelle', 'ASC')
            ->getQuery()
            ->getArrayResult();

        $valorisateurRows = $this->createQueryBuilder('d')
            ->select('v.id AS id, v.prenom AS prenom, v.nom AS nom, COUNT(d.id) AS total')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->where('d.deletedAt IS NULL')
            ->andWhere('v.id IS NOT NULL')
            ->groupBy('v.id, v.prenom, v.nom')
            ->orderBy('v.nom', 'ASC')
            ->addOrderBy('v.prenom', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return [
            'types' => array_map(static function (array $row): array {
                return [
                    'id' => (int) ($row['id'] ?? 0),
                    'label' => (string) ($row['label'] ?? 'Non defini'),
                    'total' => (int) ($row['total'] ?? 0),
                ];
            }, $typeRows),
            'valorisateurs' => array_map(static function (array $row): array {
                $fullName = trim((string) (($row['prenom'] ?? '').' '.($row['nom'] ?? '')));

                return [
                    'id' => (int) ($row['id'] ?? 0),
                    'label' => '' !== $fullName ? $fullName : 'Valorisateur #'.(int) ($row['id'] ?? 0),
                    'total' => (int) ($row['total'] ?? 0),
                ];
            }, $valorisateurRows),
        ];
    }

    /**
     * @return array{avgQty: float, maxQty: float}
     */
    public function getRiskReference(): array
    {
        $row = $this->createQueryBuilder('d')
            ->select('COALESCE(AVG(d.quantite), 0) AS avgQty')
            ->addSelect('COALESCE(MAX(d.quantite), 0) AS maxQty')
            ->where('d.deletedAt IS NULL')
            ->getQuery()
            ->getOneOrNullResult();

        return [
            'avgQty' => (float) ($row['avgQty'] ?? 0),
            'maxQty' => (float) ($row['maxQty'] ?? 0),
        ];
    }

    /**
     * @return array<int, array{lat: float, lng: float, weight: int}>
     */
    public function getHeatmapPoints(array $filters, int $maxPoints = 80): array
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.latitude AS lat, d.longitude AS lng')
            ->leftJoin('d.citoyen', 'c')
            ->leftJoin('d.typeDechet', 't')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.latitude IS NOT NULL')
            ->andWhere('d.longitude IS NOT NULL');

        $this->applyAdminFilters($qb, $filters);

        $rows = $qb
            ->setMaxResults(2500)
            ->getQuery()
            ->getArrayResult();

        $groups = [];
        foreach ($rows as $row) {
            $lat = round((float) ($row['lat'] ?? 0), 2);
            $lng = round((float) ($row['lng'] ?? 0), 2);
            $key = sprintf('%s|%s', number_format($lat, 2, '.', ''), number_format($lng, 2, '.', ''));
            $groups[$key] = ($groups[$key] ?? 0) + 1;
        }

        arsort($groups);
        $points = [];
        foreach (\array_slice($groups, 0, max(1, $maxPoints), true) as $key => $weight) {
            [$lat, $lng] = explode('|', $key);
            $points[] = [
                'lat' => (float) $lat,
                'lng' => (float) $lng,
                'weight' => (int) $weight,
            ];
        }

        return $points;
    }

    /**
     * @return array<int, array{kind: string, icon: string, label: string, message: string, dateIso: string}>
     */
    public function getRealtimeActivity(int $limit = 8): array
    {
        $declarations = $this->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->addSelect('v')
            ->orderBy('d.id', 'DESC')
            ->setMaxResults(max(20, $limit * 4))
            ->getQuery()
            ->getResult();

        $events = [];
        foreach ($declarations as $declaration) {
            if (!$declaration instanceof DeclarationDechet) {
                continue;
            }

            $typeLabel = $declaration->getTypeDechet()?->getLibelle() ?? 'Non defini';
            $citoyenName = trim((string) (($declaration->getCitoyen()?->getPrenom() ?? '').' '.($declaration->getCitoyen()?->getNom() ?? '')));
            $citoyenName = '' !== $citoyenName ? $citoyenName : 'Citoyen inconnu';
            $baseMessage = sprintf('#%d - %s - %s', $declaration->getId(), $typeLabel, $citoyenName);

            if ($declaration->getCreatedAt() instanceof \DateTimeInterface) {
                $events[] = [
                    'kind' => 'creation',
                    'icon' => 'fa-file-circle-plus',
                    'label' => 'Nouvelle declaration',
                    'message' => $baseMessage,
                    'timestamp' => $declaration->getCreatedAt()->getTimestamp(),
                ];
            }

            if ($declaration->getDateConfirmation() instanceof \DateTimeInterface) {
                $valorisateurName = trim((string) (($declaration->getValorisateurConfirmateur()?->getPrenom() ?? '').' '.($declaration->getValorisateurConfirmateur()?->getNom() ?? '')));
                $events[] = [
                    'kind' => 'approval',
                    'icon' => 'fa-circle-check',
                    'label' => 'Declaration approuvee',
                    'message' => sprintf('%s - Validee par %s', $baseMessage, '' !== $valorisateurName ? $valorisateurName : 'Valorisateur'),
                    'timestamp' => $declaration->getDateConfirmation()->getTimestamp(),
                ];
            }

            if ($declaration->getDeletedAt() instanceof \DateTimeInterface) {
                $events[] = [
                    'kind' => 'deletion',
                    'icon' => 'fa-trash',
                    'label' => 'Declaration supprimee',
                    'message' => $baseMessage,
                    'timestamp' => $declaration->getDeletedAt()->getTimestamp(),
                ];
            }
        }

        usort($events, static fn (array $a, array $b): int => (int) ($b['timestamp'] <=> $a['timestamp']));

        $events = \array_slice($events, 0, max(1, $limit));

        return array_map(static function (array $event): array {
            $timestamp = (int) ($event['timestamp'] ?? time());

            return [
                'kind' => (string) ($event['kind'] ?? 'event'),
                'icon' => (string) ($event['icon'] ?? 'fa-bell'),
                'label' => (string) ($event['label'] ?? 'Activite'),
                'message' => (string) ($event['message'] ?? '-'),
                'dateIso' => date(DATE_ATOM, $timestamp),
            ];
        }, $events);
    }

    /**
     * @return array{totalDeclarations: int, totalApproved: int, totalPending: int, totalDeleted: int, totalEcoPoints: int}
     */
    public function getAdminStatCards(): array
    {
        $row = $this->createQueryBuilder('d')
            ->select('COUNT(d.id) AS totalDeclarations')
            ->addSelect('SUM(CASE WHEN d.statut = :approved THEN 1 ELSE 0 END) AS totalApproved')
            ->addSelect('SUM(CASE WHEN d.statut = :pending THEN 1 ELSE 0 END) AS totalPending')
            ->addSelect('COALESCE(SUM(d.pointsAttribues), 0) AS totalEcoPoints')
            ->andWhere('d.deletedAt IS NULL')
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->setParameter('pending', DeclarationDechet::STATUT_EN_ATTENTE)
            ->getQuery()
            ->getSingleResult();

        $deletedCount = (int) $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.deletedAt IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'totalDeclarations' => (int) ($row['totalDeclarations'] ?? 0),
            'totalApproved' => (int) ($row['totalApproved'] ?? 0),
            'totalPending' => (int) ($row['totalPending'] ?? 0),
            'totalDeleted' => $deletedCount,
            'totalEcoPoints' => (int) ($row['totalEcoPoints'] ?? 0),
        ];
    }

    /**
     * @return array{labels: array<int, string>, values: array<int, int>}
     */
    public function getDeclarationsByTypeStats(array $filters = []): array
    {
        $rows = $this->createQueryBuilder('d')
            ->select('COALESCE(t.libelle, :fallback) AS typeLabel, COUNT(d.id) AS total')
            ->leftJoin('d.citoyen', 'c')
            ->leftJoin('d.typeDechet', 't')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->where('d.deletedAt IS NULL')
            ->setParameter('fallback', 'Non defini');

        $this->applyAdminFilters($rows, $filters);

        $rows = $rows
            ->groupBy('t.id, t.libelle')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getArrayResult();

        $labels = [];
        $values = [];
        foreach ($rows as $row) {
            $labels[] = (string) ($row['typeLabel'] ?? 'Non defini');
            $values[] = (int) ($row['total'] ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    public function findAdminDetailsById(int $id): ?DeclarationDechet
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.citoyen', 'c')
            ->addSelect('c')
            ->leftJoin('d.typeDechet', 't')
            ->addSelect('t')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->addSelect('v')
            ->where('d.id = :id')
            ->andWhere('d.deletedAt IS NULL')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return array{
     *     typeMostDeclared: array{label: string, total: int}|null,
     *     mostActiveValorisateur: array{name: string, total: int}|null,
     *     hottestZone: array{label: string, total: int}|null,
     *     suspiciousDeclarations: array<int, array<string, mixed>>
     * }
     */
    public function getIntelligenceInsights(): array
    {
        $typeMostDeclared = $this->createQueryBuilder('d')
            ->select('COALESCE(t.libelle, :fallback) AS label, COUNT(d.id) AS total')
            ->leftJoin('d.typeDechet', 't')
            ->where('d.deletedAt IS NULL')
            ->groupBy('t.id, t.libelle')
            ->orderBy('total', 'DESC')
            ->setMaxResults(1)
            ->setParameter('fallback', 'Non defini')
            ->getQuery()
            ->getOneOrNullResult();

        $mostActiveValorisateur = $this->createQueryBuilder('d')
            ->select('v.prenom AS prenom, v.nom AS nom, COUNT(d.id) AS total')
            ->leftJoin('d.valorisateurConfirmateur', 'v')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.statut = :approved')
            ->andWhere('v.id IS NOT NULL')
            ->groupBy('v.id, v.prenom, v.nom')
            ->orderBy('total', 'DESC')
            ->setMaxResults(1)
            ->setParameter('approved', DeclarationDechet::STATUT_APPROUVEE)
            ->getQuery()
            ->getOneOrNullResult();

        $zoneRows = $this->createQueryBuilder('d')
            ->select('d.latitude AS lat, d.longitude AS lng')
            ->where('d.deletedAt IS NULL')
            ->getQuery()
            ->getArrayResult();

        $zoneCounter = [];
        foreach ($zoneRows as $row) {
            $lat = isset($row['lat']) ? round((float) $row['lat'], 2) : null;
            $lng = isset($row['lng']) ? round((float) $row['lng'], 2) : null;
            if ($lat === null || $lng === null) {
                continue;
            }

            $key = sprintf('%s|%s', number_format($lat, 2, '.', ''), number_format($lng, 2, '.', ''));
            $zoneCounter[$key] = ($zoneCounter[$key] ?? 0) + 1;
        }
        arsort($zoneCounter);
        $hottestZone = null;
        if ([] !== $zoneCounter) {
            $zoneKey = (string) array_key_first($zoneCounter);
            [$lat, $lng] = explode('|', $zoneKey);
            $hottestZone = [
                'label' => sprintf('Lat %s / Lng %s', $lat, $lng),
                'total' => (int) $zoneCounter[$zoneKey],
            ];
        }

        $avgQuantity = (float) $this->createQueryBuilder('d')
            ->select('COALESCE(AVG(d.quantite), 0)')
            ->where('d.deletedAt IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
        $threshold = max(5.0, round($avgQuantity * 2, 2));

        $suspiciousRows = $this->createQueryBuilder('d')
            ->select('d.id AS id')
            ->addSelect('d.quantite AS quantite')
            ->addSelect('d.unite AS unite')
            ->addSelect('d.statut AS statut')
            ->addSelect('d.createdAt AS createdAt')
            ->addSelect('COALESCE(c.nom, \'\') AS citoyenNom')
            ->addSelect('COALESCE(c.prenom, \'\') AS citoyenPrenom')
            ->addSelect('COALESCE(t.libelle, :fallback) AS typeLabel')
            ->leftJoin('d.citoyen', 'c')
            ->leftJoin('d.typeDechet', 't')
            ->where('d.deletedAt IS NULL')
            ->andWhere('d.quantite >= :threshold')
            ->orderBy('d.quantite', 'DESC')
            ->addOrderBy('d.id', 'DESC')
            ->setMaxResults(5)
            ->setParameter('threshold', $threshold)
            ->setParameter('fallback', 'Non defini')
            ->getQuery()
            ->getArrayResult();

        return [
            'typeMostDeclared' => $typeMostDeclared
                ? [
                    'label' => (string) ($typeMostDeclared['label'] ?? 'Non defini'),
                    'total' => (int) ($typeMostDeclared['total'] ?? 0),
                ]
                : null,
            'mostActiveValorisateur' => $mostActiveValorisateur
                ? [
                    'name' => trim((string) (($mostActiveValorisateur['prenom'] ?? '').' '.($mostActiveValorisateur['nom'] ?? ''))) ?: 'Non disponible',
                    'total' => (int) ($mostActiveValorisateur['total'] ?? 0),
                ]
                : null,
            'hottestZone' => $hottestZone,
            'suspiciousDeclarations' => array_map(static function (array $row) use ($threshold): array {
                $citoyen = trim((string) (($row['citoyenPrenom'] ?? '').' '.($row['citoyenNom'] ?? '')));
                $quantite = (float) ($row['quantite'] ?? 0);
                $riskScore = self::calculateRiskScoreFromThreshold($quantite, $threshold);

                return [
                    'id' => (int) ($row['id'] ?? 0),
                    'typeLabel' => (string) ($row['typeLabel'] ?? 'Non defini'),
                    'citoyen' => '' !== $citoyen ? $citoyen : 'Anonyme',
                    'quantite' => $quantite,
                    'unite' => (string) ($row['unite'] ?? ''),
                    'statut' => (string) ($row['statut'] ?? DeclarationDechet::STATUT_EN_ATTENTE),
                    'createdAt' => self::normalizeDateValue($row['createdAt'] ?? null),
                    'riskScore' => $riskScore,
                    'riskLabel' => self::riskLabelFromScore($riskScore),
                ];
            }, $suspiciousRows),
        ];
    }

    private function applyAdminFilters(QueryBuilder $qb, array $filters): void
    {
        $status = (string) ($filters['status'] ?? '');
        $allowedStatuses = [
            DeclarationDechet::STATUT_EN_ATTENTE,
            DeclarationDechet::STATUT_APPROUVEE,
            DeclarationDechet::STATUT_REFUSEE,
        ];
        if (\in_array($status, $allowedStatuses, true)) {
            $qb->andWhere('d.statut = :status')
                ->setParameter('status', $status);
        }

        $search = strtolower(trim((string) ($filters['search'] ?? '')));
        if ('' !== $search) {
            $qb->andWhere('(LOWER(COALESCE(c.nom, \'\')) LIKE :search OR LOWER(COALESCE(c.prenom, \'\')) LIKE :search OR LOWER(COALESCE(c.email, \'\')) LIKE :search)')
                ->setParameter('search', '%'.$search.'%');
        }

        $typeId = (int) ($filters['type'] ?? 0);
        if ($typeId > 0) {
            $qb->andWhere('t.id = :typeId')
                ->setParameter('typeId', $typeId);
        }

        $valorisateurId = (int) ($filters['valorisateur'] ?? 0);
        if ($valorisateurId > 0) {
            $qb->andWhere('v.id = :valorisateurId')
                ->setParameter('valorisateurId', $valorisateurId);
        }

        $quantityMin = $this->toNullableFloat($filters['quantityMin'] ?? null);
        $quantityMax = $this->toNullableFloat($filters['quantityMax'] ?? null);
        if ($quantityMin !== null && $quantityMax !== null && $quantityMin > $quantityMax) {
            [$quantityMin, $quantityMax] = [$quantityMax, $quantityMin];
        }
        if ($quantityMin !== null) {
            $qb->andWhere('d.quantite >= :quantityMin')
                ->setParameter('quantityMin', $quantityMin);
        }
        if ($quantityMax !== null) {
            $qb->andWhere('d.quantite <= :quantityMax')
                ->setParameter('quantityMax', $quantityMax);
        }
    }

    private function toNullableFloat(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            return null;
        }

        return (float) $value;
    }

    private static function normalizeDateValue(mixed $value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format(DATE_ATOM);
        }

        if (null === $value) {
            return '';
        }

        return (string) $value;
    }

    private static function calculateRiskScoreFromThreshold(float $quantity, float $threshold): int
    {
        $base = $threshold > 0 ? ($quantity / $threshold) * 100 : 0;

        return (int) max(0, min(100, round($base)));
    }

    private static function riskLabelFromScore(int $score): string
    {
        if ($score >= 75) {
            return 'Eleve';
        }
        if ($score >= 45) {
            return 'Moyen';
        }

        return 'Faible';
    }
}
