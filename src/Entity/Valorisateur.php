<?php

namespace App\Entity;

use App\Entity\Embeddable\EmailAddress;
use App\Repository\ValorisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValorisateurRepository::class)]
class Valorisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_societe', length: 255)]
    private string $nomSociete = '';

    #[ORM\Embedded(class: EmailAddress::class, columnPrefix: false)]
    private EmailAddress $emailAddress;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, AppelOffre>
     */
    #[ORM\OneToMany(targetEntity: AppelOffre::class, mappedBy: 'valorisateur')]
    private Collection $appelOffres;

    public function __construct()
    {
        $this->appelOffres = new ArrayCollection();
        $this->emailAddress = new EmailAddress();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSociete(): string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(string $nomSociete): static
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->emailAddress->getValue();
    }

    public function setEmail(string $email): static
    {
        $this->emailAddress->setValue($email);

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, AppelOffre>
     */
    public function getAppelOffres(): Collection
    {
        return $this->appelOffres;
    }

    public function addAppelOffre(AppelOffre $appelOffre): static
    {
        if (!$this->appelOffres->contains($appelOffre)) {
            $this->appelOffres->add($appelOffre);
            $appelOffre->setValorisateur($this);
        }

        return $this;
    }

    public function removeAppelOffre(AppelOffre $appelOffre): static
    {
        if ($this->appelOffres->removeElement($appelOffre)) {
            if ($appelOffre->getValorisateur() === $this) {
                $appelOffre->setValorisateur(null);
            }
        }

        return $this;
    }
}
