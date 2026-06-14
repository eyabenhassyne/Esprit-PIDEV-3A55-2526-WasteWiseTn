<?php

namespace App\Entity;

use App\Repository\BadgePartenaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BadgePartenaireRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'badge_partenaire', indexes: [
    new ORM\Index(name: 'idx_badge_partenaire', columns: ['partenaire_id']),
    new ORM\Index(name: 'idx_badge_is_current', columns: ['is_current']),
])]
class BadgePartenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id = 0;

    #[ORM\ManyToOne(inversedBy: 'badgesPartenaire', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $partenaire = null;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: false)]
    private string $code = 'PARTENAIRE_VERT';

    #[ORM\Column(type: Types::STRING, length: 120, nullable: false)]
    private string $nom = 'Partenaire Vert';

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $description = 'Badge debutant';

    #[ORM\Column(type: Types::STRING, length: 12, nullable: false)]
    private string $couleur = '#5cb85c';

    #[ORM\Column(type: Types::STRING, length: 50, nullable: false)]
    private string $icone = 'fa-seedling';

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $scoreImpact = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isCurrent = true;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt instanceof \DateTimeImmutable
            ? $createdAt
            : \DateTimeImmutable::createFromMutable($createdAt);

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt instanceof \DateTimeImmutable
            ? $updatedAt
            : \DateTimeImmutable::createFromMutable($updatedAt);

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

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();
        if ($this->createdAt === null) {
            $this->createdAt = $now;
        }
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
