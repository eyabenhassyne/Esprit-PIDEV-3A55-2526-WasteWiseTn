<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getTotalGainsByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COALESCE(SUM(t.montant), 0)')
            ->join('t.wallet', 'w')
            ->where('w.utilisateur = :user')
            ->andWhere('t.type = :type')
            ->setParameter('user', $user)
            ->setParameter('type', 'Gain')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalDepensesByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COALESCE(SUM(t.montant), 0)')
            ->join('t.wallet', 'w')
            ->where('w.utilisateur = :user')
            ->andWhere('t.type = :type')
            ->setParameter('user', $user)
            ->setParameter('type', 'Depense')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Transaction[]
     */
    public function getLastTransactionsByUser(User $user, int $limit = 10): array
    {
        return $this->createQueryBuilder('t')
            ->join('t.wallet', 'w')
            ->where('w.utilisateur = :user')
            ->setParameter('user', $user)
            ->orderBy('t.dateTransaction', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->join('t.wallet', 'w')
            ->where('w.utilisateur = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
