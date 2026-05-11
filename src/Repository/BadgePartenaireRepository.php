<?php

namespace App\Repository;

use App\Entity\BadgePartenaire;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BadgePartenaire>
 */
class BadgePartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BadgePartenaire::class);
    }

    public function findCurrentBadge(User $partenaire): ?BadgePartenaire
    {
        return $this->createQueryBuilder('b')
            ->where('b.partenaire = :partenaire')
            ->andWhere('b.isCurrent = :current')
            ->setParameter('partenaire', $partenaire)
            ->setParameter('current', true)
            ->orderBy('b.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function setAllAsNotCurrent(User $partenaire): void
    {
        $this->createQueryBuilder('b')
            ->update()
            ->set('b.isCurrent', ':current')
            ->set('b.updatedAt', ':updatedAt')
            ->where('b.partenaire = :partenaire')
            ->andWhere('b.isCurrent = :previousCurrent')
            ->setParameter('current', false)
            ->setParameter('updatedAt', new \DateTimeImmutable())
            ->setParameter('partenaire', $partenaire)
            ->setParameter('previousCurrent', true)
            ->getQuery()
            ->execute();
    }
}
