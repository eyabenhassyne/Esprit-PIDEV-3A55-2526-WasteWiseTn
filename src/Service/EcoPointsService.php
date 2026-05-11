<?php

namespace App\Service;

use App\Entity\DeclarationDechet;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

class EcoPointsService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly WalletRepository $walletRepository
    ) {
    }

    public function getOrCreateWallet(User $user): Wallet
    {
        $wallet = $this->walletRepository->findOneBy(['utilisateur' => $user]);
        if ($wallet instanceof Wallet) {
            return $wallet;
        }

        $wallet = new Wallet();
        $wallet->setUtilisateur($user);
        $wallet->setSoldeActuel(0);
        $wallet->setDateMj(new \DateTime());

        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        return $wallet;
    }

    public function calculatePointsFromDeclaration(DeclarationDechet $declaration): int
    {
        // Les points viennent du type de dechet configure par l'admin.
        $type = $declaration->getTypeDechet();
        if (null === $type) {
            throw new \RuntimeException('Type de dechet non defini pour cette declaration.');
        }

        $pointsParKg = (float) ($type->getValeurPointsKG() ?? 0);
        if ($pointsParKg <= 0) {
            throw new \RuntimeException('La valeur de points/kg du type de dechet est invalide.');
        }

        $quantite = (float) ($declaration->getQuantite() ?? 0);

        return (int) round($quantite * $pointsParKg);
    }

    public function addPoints(User $user, int $points, string $motif, bool $flush = true): void
    {
        $wallet = $this->getOrCreateWallet($user);
        $wallet->setSoldeActuel($wallet->getSoldeActuel() + max(0, $points));
        $wallet->setDateMj(new \DateTime());

        $transaction = new Transaction();
        $transaction->setWallet($wallet);
        $transaction->setMontant(max(0, $points));
        $transaction->setType('Gain');
        $transaction->setMotif($motif);
        $transaction->setDateTransaction(new \DateTime());

        $this->entityManager->persist($wallet);
        $this->entityManager->persist($transaction);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function addPointsForDeclaration(User $user, int $points, string $motif): void
    {
        // Methode de compatibilite avec l'ancien code.
        $this->addPoints($user, $points, $motif);
    }

    public function spendPoints(User $user, int $points, string $motif, bool $flush = true): void
    {
        if ($points <= 0) {
            throw new \RuntimeException('Le montant de points a retirer doit etre superieur a zero.');
        }

        $wallet = $this->getOrCreateWallet($user);
        if ($wallet->getSoldeActuel() < $points) {
            throw new \RuntimeException('Solde insuffisant pour effectuer ce retrait.');
        }

        $wallet->setSoldeActuel($wallet->getSoldeActuel() - $points);
        $wallet->setDateMj(new \DateTime());

        $transaction = new Transaction();
        $transaction->setWallet($wallet);
        $transaction->setMontant($points);
        $transaction->setType('Depense');
        $transaction->setMotif($motif);
        $transaction->setDateTransaction(new \DateTime());

        $this->entityManager->persist($wallet);
        $this->entityManager->persist($transaction);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
