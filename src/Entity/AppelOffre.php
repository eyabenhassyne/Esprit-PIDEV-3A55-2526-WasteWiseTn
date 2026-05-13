<?php

namespace App\Entity;

use App\Repository\AppelOffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppelOffreRepository::class)]
class AppelOffre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    private string $titre = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description est obligatoire.')]
    private string $description = '';

    #[ORM\Column]
    #[Assert\NotNull(message: 'La quantite demandee est obligatoire.')]
    #[Assert\Positive(message: 'La quantite demandee doit etre positive.')]
    private float $quantiteDemandee = 0.0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotNull(message: 'La date limite est obligatoire.')]
    #[Assert\GreaterThan('now', message: 'La date limite doit etre dans le futur.')]
    private \DateTimeImmutable $dateLimite;

    #[ORM\ManyToOne(inversedBy: 'appelOffres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le valorisateur est obligatoire.')]
    private ?Valorisateur $valorisateur = null;

    /**
     * @var Collection<int, ReponseOffre>
     */
    #[ORM\OneToMany(
        targetEntity: ReponseOffre::class,
        mappedBy: 'appelOffre',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $reponseOffres;

    public function __construct()
    {
        $this->reponseOffres = new ArrayCollection();
        $this->dateLimite = new \DateTimeImmutable('+1 day');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getQuantiteDemandee(): float
    {
        return $this->quantiteDemandee;
    }

    public function setQuantiteDemandee(float $quantiteDemandee): static
    {
        $this->quantiteDemandee = $quantiteDemandee;

        return $this;
    }

    public function getDateLimite(): \DateTimeImmutable
    {
        return $this->dateLimite;
    }

    public function defineDateLimite(\DateTimeInterface $dateLimite): static
    {
        $this->dateLimite = $dateLimite instanceof \DateTimeImmutable
            ? $dateLimite
            : \DateTimeImmutable::createFromMutable($dateLimite);

        return $this;
    }

    public function isExpired(?\DateTimeInterface $referenceDate = null): bool
    {
        $now = $referenceDate ?? new \DateTimeImmutable();

        return $this->dateLimite < $now;
    }

    public function getValorisateur(): ?Valorisateur
    {
        return $this->valorisateur;
    }

    public function setValorisateur(?Valorisateur $valorisateur): static
    {
        $this->valorisateur = $valorisateur;

        return $this;
    }

    /**
     * @return Collection<int, ReponseOffre>
     */
    public function getReponseOffres(): Collection
    {
        return $this->reponseOffres;
    }

    public function addReponseOffre(ReponseOffre $reponseOffre): static
    {
        if (!$this->reponseOffres->contains($reponseOffre)) {
            $this->reponseOffres->add($reponseOffre);
            $reponseOffre->setAppelOffre($this);
        }

        return $this;
    }

    public function removeReponseOffre(ReponseOffre $reponseOffre): static
    {
        if ($this->reponseOffres->removeElement($reponseOffre)) {
            // set the owning side to null (unless already changed)
            if ($reponseOffre->getAppelOffre() === $this) {
                $reponseOffre->setAppelOffre(null);
            }
        }

        return $this;
    }
}
