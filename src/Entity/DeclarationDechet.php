<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\DeclarationDechetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeclarationDechetRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'declaration_dechet', indexes: [
    new ORM\Index(name: 'idx_declaration_citoyen', columns: ['citoyen_id']),
    new ORM\Index(name: 'idx_declaration_type_dechet', columns: ['type_dechet_id']),
    new ORM\Index(name: 'idx_declaration_statut', columns: ['statut']),
    new ORM\Index(name: 'idx_declaration_created_at', columns: ['created_at']),
    new ORM\Index(name: 'idx_declaration_deleted_at', columns: ['deleted_at']),
    new ORM\Index(name: 'idx_declaration_citoyen_created', columns: ['citoyen_id', 'created_at']),
])]
class DeclarationDechet
{
    public const STATUT_EN_ATTENTE = 'EN_ATTENTE';
    public const STATUT_APPROUVEE = 'APPROUVEE';
    public const STATUT_REFUSEE = 'REFUSEE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'declarationDechets', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDechet $typeDechet = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private ?float $latitude = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private ?float $longitude = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private ?float $quantite = null;

    #[ORM\Column(type: Types::STRING, length: 16, nullable: false)]
    private ?string $unite = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $scoreIa = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $pointsAttribues = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $qrCode = null;

    #[ORM\ManyToOne(inversedBy: 'declarations', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $citoyen = null;

    #[ORM\ManyToOne(fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $valorisateurConfirmateur = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateConfirmation = null;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $statutHistorique = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $Description): static
    {
        $normalizedDescription = trim((string) $Description);
        if ('' === $normalizedDescription) {
            throw new \InvalidArgumentException('La description est obligatoire.');
        }

        $this->description = $normalizedDescription;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTypeDechet(): ?TypeDechet
    {
        return $this->typeDechet;
    }

    public function setTypeDechet(?TypeDechet $TypeDechet): static
    {
        $this->typeDechet = $TypeDechet;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function validateLocation(): void
    {
        if ($this->latitude === null || $this->longitude === null) {
            throw new \InvalidArgumentException('La localisation GPS est obligatoire.');
        }
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException('La quantite doit etre strictement positive.');
        }

        $this->quantite = $quantite;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

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

    public function getScoreIa(): ?float
    {
        return $this->scoreIa;
    }

    public function setScoreIa(?float $scoreIa): static
    {
        $this->scoreIa = $scoreIa;

        return $this;
    }

    public function getPointsAttribues(): int
    {
        return $this->pointsAttribues;
    }

    public function setPointsAttribues(int $pointsAttribues): static
    {
        $this->pointsAttribues = $pointsAttribues;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(?string $qrCode): static
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getCitoyen(): ?User
    {
        return $this->citoyen;
    }

    public function setCitoyen(?User $citoyen): static
    {
        $this->citoyen = $citoyen;

        return $this;
    }

    public function getValorisateurConfirmateur(): ?User
    {
        return $this->valorisateurConfirmateur;
    }

    public function setValorisateurConfirmateur(?User $valorisateurConfirmateur): static
    {
        $this->valorisateurConfirmateur = $valorisateurConfirmateur;

        return $this;
    }

    public function getDateConfirmation(): ?\DateTimeImmutable
    {
        return $this->dateConfirmation;
    }

    public function setDateConfirmation(?\DateTimeInterface $dateConfirmation): static
    {
        $this->dateConfirmation = $dateConfirmation === null
            ? null
            : ($dateConfirmation instanceof \DateTimeImmutable
                ? $dateConfirmation
                : \DateTimeImmutable::createFromMutable($dateConfirmation));

        return $this;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getStatutHistorique(): array
    {
        if (!isset($this->statutHistorique) || !\is_array($this->statutHistorique)) {
            return [];
        }

        return $this->statutHistorique;
    }

    /**
     * @param array<int, array<string, mixed>>|null $statutHistorique
     */
    public function setStatutHistorique(?array $statutHistorique): static
    {
        $this->statutHistorique = $statutHistorique ?? [];

        return $this;
    }

    public function addHistoriqueStatut(
        string $statut,
        ?string $acteur = null,
        ?string $note = null,
        ?\DateTimeInterface $date = null
    ): static {
        $events = $this->getStatutHistorique();
        $eventDate = $date ?? new \DateTimeImmutable();
        $events[] = [
            'statut' => $statut,
            'acteur' => $acteur,
            'note' => $note,
            'date' => $eventDate->format(DATE_ATOM),
        ];
        $this->statutHistorique = $events;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt === null
            ? null
            : ($deletedAt instanceof \DateTimeImmutable
                ? $deletedAt
                : \DateTimeImmutable::createFromMutable($deletedAt));

        return $this;
    }

    #[ORM\PrePersist]
    public function ensureCreatedAt(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }
}
