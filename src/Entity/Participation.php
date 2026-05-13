<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du citoyen est obligatoire.")]
    #[Assert\Length(
        min: 3, 
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères."
    )]
    private ?string $nomCitoyen = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date d'inscription est obligatoire.")]
    #[Assert\Type("\DateTimeInterface")]
    
    #[Assert\LessThanOrEqual(
        value: "today",
        message: "La date d'inscription ne peut pas être dans le futur."
    )]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull(message: "Veuillez sélectionner un événement.")]
    private ?Evenement $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCitoyen(): ?string
    {
        return $this->nomCitoyen;
    }

    public function setNomCitoyen(string $nomCitoyen): static
    {
        $this->nomCitoyen = $nomCitoyen;
        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;
        return $this;
    }

    

public function __construct()
{
    
    $this->dateInscription = new \DateTime();
}
}