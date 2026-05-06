<?php

namespace App\Repository;

use App\Entity\ResetPasswordToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResetPasswordToken>
 */
class ResetPasswordTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordToken::class);
    }

    public function findValidToken(string $token): ?ResetPasswordToken
    {
        /** @var ResetPasswordToken|null $t */
        $t = $this->findOneBy(['token' => $token]);

        if (!$t) {
            return null;
        }

        if ($t->isUsed() || $t->isExpired()) {
            return null;
        }

        return $t;
    }
}