<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'wallet_transaction', indexes: [
    new ORM\Index(name: 'idx_transaction_wallet', columns: ['wallet_id']),
    new ORM\Index(name: 'idx_transaction_date', columns: ['date_transaction']),
    new ORM\Index(name: 'idx_transaction_type', columns: ['type']),
])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_transaction', type: 'integer')]
    private int $id = 0;

    #[ORM\ManyToOne(inversedBy: 'transactions', fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'wallet_id', referencedColumnName: 'id_wallet', nullable: false)]
    private ?Wallet $wallet = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $montant = 0;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $motif = null;

    #[ORM\Column(name: 'date_transaction', type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateTransaction = null;

    public function __construct()
    {
        $this->dateTransaction = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): static
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getMontant(): int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeImmutable
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): static
    {
        $this->dateTransaction = $dateTransaction instanceof \DateTimeImmutable
            ? $dateTransaction
            : \DateTimeImmutable::createFromMutable($dateTransaction);

        return $this;
    }

    #[ORM\PrePersist]
    public function ensureDateTransaction(): void
    {
        if ($this->dateTransaction === null) {
            $this->dateTransaction = new \DateTimeImmutable();
        }
    }
}
