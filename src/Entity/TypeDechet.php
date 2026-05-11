<?php

namespace App\Entity;

use App\Repository\TypeDechetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDechetRepository::class)]
class TypeDechet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $valeurPointsKg = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionTri = null;

    #[ORM\OneToMany(mappedBy: 'typeDechet', targetEntity: DeclarationDechet::class)]
    private Collection $declarationDechets;

    public function __construct()
    {
        $this->declarationDechets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getValeurPointsKg(): ?float
    {
        return $this->valeurPointsKg;
    }

    public function setValeurPointsKg(float $valeurPointsKg): static
    {
        $this->valeurPointsKg = $valeurPointsKg;
        return $this;
    }

    public function getDescriptionTri(): ?string
    {
        return $this->descriptionTri;
    }

    public function setDescriptionTri(string $descriptionTri): static
    {
        $this->descriptionTri = $descriptionTri;
        return $this;
    }

    /**
     * @return Collection<int, DeclarationDechet>
     */
    public function getDeclarationDechets(): Collection
    {
        return $this->declarationDechets;
    }

    public function addDeclarationDechet(DeclarationDechet $declarationDechet): static
    {
        if (!$this->declarationDechets->contains($declarationDechet)) {
            $this->declarationDechets->add($declarationDechet);
            $declarationDechet->setTypeDechet($this);
        }

        return $this;
    }

    public function removeDeclarationDechet(DeclarationDechet $declarationDechet): static
    {
        if ($this->declarationDechets->removeElement($declarationDechet)) {
            if ($declarationDechet->getTypeDechet() === $this) {
                $declarationDechet->setTypeDechet(null);
            }
        }

        return $this;
    }
}
