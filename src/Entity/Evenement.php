<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    
    #[Assert\NotBlank(message: "Le titre de l'événement est obligatoire.")]
    #[Assert\Length(min: 5, minMessage: "Le titre doit avoir au moins 5 caractères.")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(min: 10, minMessage: "La description doit avoir au moins 10 caractères.")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
   
    #[Assert\NotBlank(message: "La date est obligatoire.")]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "L'événement ne peut pas être organisé dans le passé."
    )]
    private ?\DateTimeInterface $dateHeure = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'evenement')]
    private Collection $participations;

    #[ORM\Column(length: 255)]
   
    #[Assert\NotBlank(message: "Le nom de l'organisateur est obligatoire.")]
    private ?string $nomOrganisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
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

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;
        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setEvenement($this);
        }
        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            if ($participation->getEvenement() === $this) {
                $participation->setEvenement(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->title; 
    }

    public function getNomOrganisateur(): ?string
    {
        return $this->nomOrganisateur;
    }

    public function setNomOrganisateur(string $nomOrganisateur): static
    {
        $this->nomOrganisateur = $nomOrganisateur;
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }
}