<?php

namespace App\Repository;

use App\Entity\BonAchat;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BonAchat>
 */
class BonAchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonAchat::class);
    }

    /**
     * @return BonAchat[]
     */
    public function findByPartenaireOrdered(User $partenaire): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.partenaire = :partenaire')
            ->setParameter('partenaire', $partenaire)
            ->orderBy('b.updatedAt', 'DESC')
            ->addOrderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return BonAchat[]
     */
    public function findExpiringSoon(User $partenaire, int $days = 7): array
    {
        $today = new \DateTimeImmutable('today');
        $deadline = $today->modify(sprintf('+%d days', max(1, $days)));

        return $this->createQueryBuilder('b')
            ->where('b.partenaire = :partenaire')
            ->andWhere('b.dateExpiration BETWEEN :today AND :deadline')
            ->andWhere('b.statut = :status')
            ->setParameter('partenaire', $partenaire)
            ->setParameter('today', $today)
            ->setParameter('deadline', $deadline)
            ->setParameter('status', BonAchat::STATUT_ACTIF)
            ->orderBy('b.dateExpiration', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array{
     *     total: int,
     *     active: int,
     *     used: int,
     *     distributedValue: float,
     *     potentialValue: float,
     *     expiringSoon: int
     * }
     */
    public function getPartnerKpis(User $partenaire): array
    {
        $row = $this->createQueryBuilder('b')
            ->select('COUNT(b.id) AS total')
            ->addSelect('SUM(CASE WHEN b.statut = :active THEN 1 ELSE 0 END) AS active')
            ->addSelect('COALESCE(SUM(b.nombreUtilisations), 0) AS used')
            ->addSelect('COALESCE(SUM(b.nombreUtilisations * b.valeurMonetaire), 0) AS distributedValue')
            ->addSelect('COALESCE(SUM(b.nombreMaximumUtilisations * b.valeurMonetaire), 0) AS potentialValue')
            ->where('b.partenaire = :partenaire')
            ->setParameter('partenaire', $partenaire)
            ->setParameter('active', BonAchat::STATUT_ACTIF)
            ->getQuery()
            ->getOneOrNullResult();

        $expiringSoon = (int) $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->where('b.partenaire = :partenaire')
            ->andWhere('b.dateExpiration BETWEEN :today AND :deadline')
            ->andWhere('b.statut = :status')
            ->setParameter('partenaire', $partenaire)
            ->setParameter('today', new \DateTimeImmutable('today'))
            ->setParameter('deadline', new \DateTimeImmutable('+7 days'))
            ->setParameter('status', BonAchat::STATUT_ACTIF)
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'total' => (int) ($row['total'] ?? 0),
            'active' => (int) ($row['active'] ?? 0),
            'used' => (int) ($row['used'] ?? 0),
            'distributedValue' => (float) ($row['distributedValue'] ?? 0),
            'potentialValue' => (float) ($row['potentialValue'] ?? 0),
            'expiringSoon' => $expiringSoon,
        ];
    }

    /**
     * @return array<int, array{magasin: string, bons: int, utilisations: int, valeurDistribuee: float}>
     */
    public function getStorePerformance(User $partenaire): array
    {
        $rows = $this->createQueryBuilder('b')
            ->select('b.nomMagasin AS magasin')
            ->addSelect('COUNT(b.id) AS bons')
            ->addSelect('COALESCE(SUM(b.nombreUtilisations), 0) AS utilisations')
            ->addSelect('COALESCE(SUM(b.nombreUtilisations * b.valeurMonetaire), 0) AS valeurDistribuee')
            ->where('b.partenaire = :partenaire')
            ->setParameter('partenaire', $partenaire)
            ->groupBy('b.nomMagasin')
            ->orderBy('valeurDistribuee', 'DESC')
            ->addOrderBy('utilisations', 'DESC')
            ->getQuery()
            ->getArrayResult();

        return array_map(static function (array $row): array {
            return [
                'magasin' => (string) ($row['magasin'] ?? 'Magasin'),
                'bons' => (int) ($row['bons'] ?? 0),
                'utilisations' => (int) ($row['utilisations'] ?? 0),
                'valeurDistribuee' => (float) ($row['valeurDistribuee'] ?? 0),
            ];
        }, $rows);
    }

    /**
     * @return array{labels: array<int, string>, values: array<int, float>}
     */
    public function getMonthlyDistributedValue(User $partenaire): array
    {
        $today = new \DateTimeImmutable('first day of this month');
        $months = [];
        for ($i = 5; $i >= 0; --$i) {
            $months[] = $today->modify(sprintf('-%d month', $i))->format('Y-m');
        }

        $conn = $this->getEntityManager()->getConnection();
        $rows = $conn->fetchAllAssociative(
            "
                SELECT DATE_FORMAT(created_at, '%Y-%m') AS bucket,
                       COALESCE(SUM(nombre_utilisations * valeur_monetaire), 0) AS total
                FROM bon_achat
                WHERE partenaire_id = :partenaireId
                GROUP BY YEAR(created_at), MONTH(created_at)
                ORDER BY YEAR(created_at), MONTH(created_at)
            ",
            ['partenaireId' => $partenaire->getId()]
        );

        $byMonth = [];
        foreach ($rows as $row) {
            $bucket = (string) ($row['bucket'] ?? '');
            if ('' === $bucket) {
                continue;
            }
            $byMonth[$bucket] = (float) ($row['total'] ?? 0);
        }

        return [
            'labels' => array_map(static function (string $bucket): string {
                [$y, $m] = explode('-', $bucket);

                return sprintf('%02d/%s', (int) $m, $y);
            }, $months),
            'values' => array_map(static fn (string $bucket): float => (float) ($byMonth[$bucket] ?? 0), $months),
        ];
    }

    /**
     * @return BonAchat[]
     */
    public function findForFiscalPeriod(User $partenaire, ?\DateTimeInterface $from, ?\DateTimeInterface $to): array
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.partenaire = :partenaire')
            ->setParameter('partenaire', $partenaire)
            ->orderBy('b.createdAt', 'DESC')
            ->addOrderBy('b.id', 'DESC');

        if ($from instanceof \DateTimeInterface) {
            $qb->andWhere('b.createdAt >= :from')
                ->setParameter('from', $from);
        }

        if ($to instanceof \DateTimeInterface) {
            $end = \DateTimeImmutable::createFromInterface($to)->modify('+1 day');
            $qb->andWhere('b.createdAt < :to')
                ->setParameter('to', $end);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array<int, array{partnerId: int, partnerName: string, score: int}>
     */
    public function getImpactRanking(int $limit = 10): array
    {
        $rows = $this->createQueryBuilder('b')
            ->select('p.id AS partnerId')
            ->addSelect('COALESCE(p.prenom, \'\') AS prenom')
            ->addSelect('COALESCE(p.nom, \'\') AS nom')
            ->addSelect('COALESCE(SUM((b.nombreUtilisations * b.valeurMonetaire) + (b.pointsRequis * 0.15)), 0) AS score')
            ->leftJoin('b.partenaire', 'p')
            ->groupBy('p.id, p.prenom, p.nom')
            ->orderBy('score', 'DESC')
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getArrayResult();

        return array_map(static function (array $row): array {
            $name = trim((string) (($row['prenom'] ?? '').' '.($row['nom'] ?? '')));

            return [
                'partnerId' => (int) ($row['partnerId'] ?? 0),
                'partnerName' => '' !== $name ? $name : 'Partenaire #'.(int) ($row['partnerId'] ?? 0),
                'score' => (int) round((float) ($row['score'] ?? 0)),
            ];
        }, $rows);
    }
}
