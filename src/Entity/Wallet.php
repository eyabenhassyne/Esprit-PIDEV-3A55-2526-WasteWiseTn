<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'wallet', indexes: [
    new ORM\Index(name: 'idx_wallet_user', columns: ['utilisateur_id']),
    new ORM\Index(name: 'idx_wallet_date_mj', columns: ['date_mj']),
])]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_wallet', type: 'integer')]
    private int $id = 0;

    #[ORM\OneToOne(inversedBy: 'wallet', fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'utilisateur_id', referencedColumnName: 'id', nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column(name: 'solde_actuel', type: 'integer', nullable: false)]
    private int $soldeActuel = 0;

    #[ORM\Column(name: 'date_mj', type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateMj = null;

    /** @var Collection<int, Transaction> */
    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Transaction::class, fetch: 'LAZY')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->dateMj = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getSoldeActuel(): int
    {
        return $this->soldeActuel;
    }

    public function setSoldeActuel(int $soldeActuel): static
    {
        $this->soldeActuel = $soldeActuel;

        return $this;
    }

    public function getDateMj(): ?\DateTimeImmutable
    {
        return $this->dateMj;
    }

    public function setDateMj(\DateTimeInterface $dateMj): static
    {
        $this->dateMj = $dateMj instanceof \DateTimeImmutable
            ? $dateMj
            : \DateTimeImmutable::createFromMutable($dateMj);

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    #[ORM\PrePersist]
    public function ensureDateMj(): void
    {
        if ($this->dateMj === null) {
            $this->dateMj = new \DateTimeImmutable();
        }
    }
}
