<?php

namespace App\Entity;

use App\Repository\BadgePartenaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BadgePartenaireRepository::class)]
class BadgePartenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'badgesPartenaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $partenaire = null;

    #[ORM\Column(length: 50)]
    private string $code = 'PARTENAIRE_VERT';

    #[ORM\Column(length: 120)]
    private string $nom = 'Partenaire Vert';

    #[ORM\Column(length: 255)]
    private string $description = 'Badge debutant';

    #[ORM\Column(length: 12)]
    private string $couleur = '#5cb85c';

    #[ORM\Column(length: 50)]
    private string $icone = 'fa-seedling';

    #[ORM\Column]
    private int $scoreImpact = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column]
    private bool $isCurrent = true;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartenaire(): ?User
    {
        return $this->partenaire;
    }

    public function setPartenaire(?User $partenaire): static
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCouleur(): string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getIcone(): string
    {
        return $this->icone;
    }

    public function setIcone(string $icone): static
    {
        $this->icone = $icone;

        return $this;
    }

    public function getScoreImpact(): int
    {
        return $this->scoreImpact;
    }

    public function setScoreImpact(int $scoreImpact): static
    {
        $this->scoreImpact = max(0, $scoreImpact);

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        if ($createdAt instanceof \DateTimeImmutable) {
            $createdAt = \DateTime::createFromImmutable($createdAt);
        }

        $this->createdAt = $createdAt instanceof \DateTime ? $createdAt : null;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        if ($updatedAt instanceof \DateTimeImmutable) {
            $updatedAt = \DateTime::createFromImmutable($updatedAt);
        }

        $this->updatedAt = $updatedAt instanceof \DateTime ? $updatedAt : null;

        return $this;
    }

    public function isCurrent(): bool
    {
        return $this->isCurrent;
    }

    public function setIsCurrent(bool $isCurrent): static
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }
}
