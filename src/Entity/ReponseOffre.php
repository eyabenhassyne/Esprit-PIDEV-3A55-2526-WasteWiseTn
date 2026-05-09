<?php

namespace App\Entity;

use App\Repository\ReponseOffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReponseOffreRepository::class)]
class ReponseOffre
{
    public const STATUT_EN_ATTENTE = 'en attente';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_REFUSE = 'refuse';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La quantite proposee est obligatoire.')]
    #[Assert\Positive(message: 'La quantite proposee doit etre positive.')]
    private float $quantiteProposee = 0.0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotNull(message: 'La date de reponse est obligatoire.')]
    private \DateTimeImmutable $dateSoumis;

    #[ORM\Column(length: 30)]
    private string $statut = self::STATUT_EN_ATTENTE;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message: 'Le message est obligatoire.')]
    #[Assert\Length(
        min: 10,
        minMessage: 'Le message doit contenir au moins {{ 10 }} caracteres.'
    )]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'reponseOffres')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull(message: 'L\'appel d\'offre est obligatoire.')]
    private ?AppelOffre $appelOffre = null;

    #[ORM\ManyToOne(inversedBy: 'reponseOffres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le citoyen est obligatoire.')]
    private ?Citoyen $citoyen = null;

    public function __construct()
    {
        $this->dateSoumis = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteProposee(): float
    {
        return $this->quantiteProposee;
    }

    public function setQuantiteProposee(float $quantiteProposee): static
    {
        $this->quantiteProposee = $quantiteProposee;

        return $this;
    }

    public function getDateSoumis(): \DateTimeImmutable
    {
        return $this->dateSoumis;
    }

    protected function setDateSoumis(\DateTimeInterface $dateSoumis): static
    {
        $this->dateSoumis = $dateSoumis instanceof \DateTimeImmutable
            ? $dateSoumis
            : \DateTimeImmutable::createFromMutable($dateSoumis);

        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = self::normalizeStatut($statut);

        return $this;
    }

    public function isEnAttente(): bool
    {
        return $this->getStatut() === self::STATUT_EN_ATTENTE;
    }

    public function canTransitionTo(string $targetStatus): bool
    {
        return $this->isEnAttente() && in_array(
            self::normalizeStatut($targetStatus),
            [self::STATUT_VALIDE, self::STATUT_REFUSE],
            true
        );
    }

    private static function normalizeStatut(string $statut): string
    {
        $normalized = strtolower(trim(str_replace('_', ' ', $statut)));

        if (in_array($normalized, ['valide', 'validee'], true)) {
            return self::STATUT_VALIDE;
        }

        if (in_array($normalized, ['refuse', 'refusee', 'rejete', 'rejetee'], true)) {
            return self::STATUT_REFUSE;
        }

        return self::STATUT_EN_ATTENTE;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getAppelOffre(): ?AppelOffre
    {
        return $this->appelOffre;
    }

    public function setAppelOffre(?AppelOffre $appelOffre): static
    {
        $this->appelOffre = $appelOffre;

        return $this;
    }

    public function getCitoyen(): ?Citoyen
    {
        return $this->citoyen;
    }

    public function setCitoyen(?Citoyen $citoyen): static
    {
        $this->citoyen = $citoyen;

        return $this;
    }
}
