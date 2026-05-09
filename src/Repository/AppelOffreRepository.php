<?php

namespace App\Repository;

use App\Entity\AppelOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppelOffre>
 */
class AppelOffreRepository extends ServiceEntityRepository
{
    private const SORT_FIELDS = [
        'titre' => 'a.titre',
        'description' => 'a.description',
        'quantiteDemandee' => 'a.quantiteDemandee',
        'dateLimite' => 'a.dateLimite',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppelOffre::class);
    }

    /**
     * @param array{quantite_min?:float|null, etat?:'active'|'expiree'|null} $filters
     * @return AppelOffre[]
     */
    public function searchAndSort(?string $query, string $sort, string $direction, array $filters = []): array
    {
        $sortField = self::SORT_FIELDS[$sort] ?? self::SORT_FIELDS['dateLimite'];
        $sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $qb = $this->createQueryBuilder('a')
            ->orderBy($sortField, $sortDirection);

        $normalizedQuery = trim((string) $query);
        if ($normalizedQuery !== '') {
            $qb
                ->andWhere('a.titre LIKE :query OR a.description LIKE :query')
                ->setParameter('query', '%'.$normalizedQuery.'%');
        }

        if (isset($filters['quantite_min'])) {
            $qb
                ->andWhere('a.quantiteDemandee >= :quantiteMin')
                ->setParameter('quantiteMin', (float) $filters['quantite_min']);
        }

        if (isset($filters['etat']) && in_array($filters['etat'], ['active', 'expiree'], true)) {
            if ($filters['etat'] === 'expiree') {
                $qb->andWhere('a.dateLimite < :now');
            } else {
                $qb->andWhere('a.dateLimite >= :now');
            }
            $qb->setParameter('now', new \DateTimeImmutable());
        }

        return $qb->getQuery()->getResult();
    }

    public function countExpired(): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.dateLimite < :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countUrgentActive(\DateTimeInterface $from, \DateTimeInterface $to): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.dateLimite >= :from')
            ->andWhere('a.dateLimite <= :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countActiveWithoutResponses(\DateTimeInterface $at): int
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(a.id)
             FROM App\Entity\AppelOffre a
             WHERE a.dateLimite >= :at
             AND NOT EXISTS (
                 SELECT 1 FROM App\Entity\ReponseOffre r WHERE r.appelOffre = a
             )'
        );

        return (int) $query
            ->setParameter('at', $at)
            ->getSingleScalarResult();
    }

}
