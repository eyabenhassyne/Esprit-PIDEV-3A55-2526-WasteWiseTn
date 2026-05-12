<?php

namespace App\Entity;

use App\Repository\BonAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BonAchatRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'bon_achat', indexes: [
    new ORM\Index(name: 'idx_bon_partenaire', columns: ['partenaire_id']),
    new ORM\Index(name: 'idx_bon_created_at', columns: ['created_at']),
    new ORM\Index(name: 'idx_bon_statut', columns: ['statut']),
])]
class BonAchat
{
    public const STATUT_ACTIF = 'ACTIF';
    public const STATUT_EXPIRE = 'EXPIRE';
    public const STATUT_EPUISE = 'EPUISE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id = 0;

    #[ORM\ManyToOne(inversedBy: 'bonsAchat', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $partenaire = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $nomMagasin = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $logoMagasin = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 2000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    #[Assert\Positive]
    private float $valeurMonetaire = 0.0;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    #[Assert\Positive]
    private int $pointsRequis = 0;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $dateExpiration = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    #[Assert\Positive]
    private int $nombreMaximumUtilisations = 1;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $nombreUtilisations = 0;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 3000)]
    private ?string $conditionsUtilisation = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $zoneGeographique = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imagePromotionnelle = null;

    #[ORM\Column(length: 32)]
    private string $statut = self::STATUT_ACTIF;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $historiqueModifications = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getNomMagasin(): ?string
    {
        return $this->nomMagasin;
    }

    public function setNomMagasin(string $nomMagasin): static
    {
        $this->nomMagasin = $nomMagasin;

        return $this;
    }

    public function getLogoMagasin(): ?string
    {
        return $this->logoMagasin;
    }

    public function setLogoMagasin(?string $logoMagasin): static
    {
        $this->logoMagasin = $logoMagasin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getValeurMonetaire(): float
    {
        return $this->valeurMonetaire;
    }

    public function setValeurMonetaire(float $valeurMonetaire): static
    {
        $this->valeurMonetaire = $valeurMonetaire;

        return $this;
    }

    public function getPointsRequis(): int
    {
        return $this->pointsRequis;
    }

    public function setPointsRequis(int $pointsRequis): static
    {
        $this->pointsRequis = $pointsRequis;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut instanceof \DateTimeImmutable
            ? $dateDebut
            : \DateTimeImmutable::createFromMutable($dateDebut);

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeImmutable
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration instanceof \DateTimeImmutable
            ? $dateExpiration
            : \DateTimeImmutable::createFromMutable($dateExpiration);

        return $this;
    }

    public function getNombreMaximumUtilisations(): int
    {
        return $this->nombreMaximumUtilisations;
    }

    public function setNombreMaximumUtilisations(int $nombreMaximumUtilisations): static
    {
        $this->nombreMaximumUtilisations = max(1, $nombreMaximumUtilisations);

        return $this;
    }

    public function getNombreUtilisations(): int
    {
        return $this->nombreUtilisations;
    }

    public function setNombreUtilisations(int $nombreUtilisations): static
    {
        $this->nombreUtilisations = max(0, $nombreUtilisations);

        return $this;
    }

    public function incrementNombreUtilisations(int $increment = 1): static
    {
        $this->nombreUtilisations = max(0, $this->nombreUtilisations + max(0, $increment));

        return $this;
    }

    public function getConditionsUtilisation(): ?string
    {
        return $this->conditionsUtilisation;
    }

    public function setConditionsUtilisation(?string $conditionsUtilisation): static
    {
        $this->conditionsUtilisation = $conditionsUtilisation;

        return $this;
    }

    public function getZoneGeographique(): ?string
    {
        return $this->zoneGeographique;
    }

    public function setZoneGeographique(?string $zoneGeographique): static
    {
        $this->zoneGeographique = $zoneGeographique;

        return $this;
    }

    public function getImagePromotionnelle(): ?string
    {
        return $this->imagePromotionnelle;
    }

    public function setImagePromotionnelle(?string $imagePromotionnelle): static
    {
        $this->imagePromotionnelle = $imagePromotionnelle;

        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getHistoriqueModifications(): array
    {
        return $this->historiqueModifications;
    }

    /**
     * @param array<int, array<string, mixed>>|null $historiqueModifications
     */
    public function setHistoriqueModifications(?array $historiqueModifications): static
    {
        $this->historiqueModifications = $historiqueModifications ?? [];

        return $this;
    }

    /**
     * @param array<string, mixed> $details
     */
    public function addHistoriqueModification(
        string $action,
        string $acteur,
        array $details = [],
        ?\DateTimeInterface $date = null
    ): static {
        $events = $this->getHistoriqueModifications();
        $eventDate = $date ?? new \DateTimeImmutable();
        $events[] = [
            'action' => $action,
            'acteur' => $acteur,
            'details' => $details,
            'date' => $eventDate->format(DATE_ATOM),
        ];
        $this->historiqueModifications = $events;

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

    public function refreshStatut(?\DateTimeInterface $referenceDate = null): static
    {
        $referenceDate = $referenceDate ?? new \DateTimeImmutable('today');
        $expired = $this->dateExpiration instanceof \DateTimeInterface && $this->dateExpiration < $referenceDate;
        $exhausted = $this->nombreUtilisations >= $this->nombreMaximumUtilisations;

        if ($exhausted) {
            $this->statut = self::STATUT_EPUISE;
        } elseif ($expired) {
            $this->statut = self::STATUT_EXPIRE;
        } else {
            $this->statut = self::STATUT_ACTIF;
        }

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
