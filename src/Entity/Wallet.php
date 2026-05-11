<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_wallet')]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'wallet')]
    #[ORM\JoinColumn(name: 'utilisateur_id', referencedColumnName: 'id', nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column(name: 'solde_actuel')]
    private int $soldeActuel = 0;

    #[ORM\Column(name: 'date_mj', type: 'datetime')]
    private ?\DateTime $dateMj = null;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->dateMj = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateMj(): ?\DateTime
    {
        return $this->dateMj;
    }

    public function setDateMj(\DateTime $dateMj): static
    {
        $this->dateMj = $dateMj;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }
}
