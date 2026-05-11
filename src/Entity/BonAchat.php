<?php

namespace App\Entity;

use App\Repository\BonAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BonAchatRepository::class)]
class BonAchat
{
    public const STATUT_ACTIF = 'ACTIF';
    public const STATUT_EXPIRE = 'EXPIRE';
    public const STATUT_EPUISE = 'EPUISE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bonsAchat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $partenaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $nomMagasin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logoMagasin = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 2000)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Positive]
    private float $valeurMonetaire = 0.0;

    #[ORM\Column]
    #[Assert\Positive]
    private int $pointsRequis = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTime $dateExpiration = null;

    #[ORM\Column]
    #[Assert\Positive]
    private int $nombreMaximumUtilisations = 1;

    #[ORM\Column]
    private int $nombreUtilisations = 0;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 3000)]
    private ?string $conditionsUtilisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $zoneGeographique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePromotionnelle = null;

    #[ORM\Column(length: 32)]
    private string $statut = self::STATUT_ACTIF;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $historiqueModifications = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $updatedAt = null;

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

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        if ($dateDebut instanceof \DateTimeImmutable) {
            $dateDebut = \DateTime::createFromImmutable($dateDebut);
        }

        $this->dateDebut = $dateDebut instanceof \DateTime ? $dateDebut : null;

        return $this;
    }

    public function getDateExpiration(): ?\DateTime
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): static
    {
        if ($dateExpiration instanceof \DateTimeImmutable) {
            $dateExpiration = \DateTime::createFromImmutable($dateExpiration);
        }

        $this->dateExpiration = $dateExpiration instanceof \DateTime ? $dateExpiration : null;

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
        return $this->historiqueModifications ?? [];
    }

    /**
     * @param array<int, array<string, mixed>>|null $historiqueModifications
     */
    public function setHistoriqueModifications(?array $historiqueModifications): static
    {
        $this->historiqueModifications = $historiqueModifications ?? [];

        return $this;
    }

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
}
