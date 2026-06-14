<?php

namespace App\Entity;

use App\Repository\TypeDechetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDechetRepository::class)]
#[ORM\Table(name: 'type_dechet', indexes: [
    new ORM\Index(name: 'idx_type_dechet_libelle', columns: ['libelle']),
])]
class TypeDechet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 0;

    #[ORM\Column(name: 'libelle', type: 'string', length: 255, nullable: false)]
    private ?string $libelle = null;

    #[ORM\Column(name: 'valeur_points_kg', type: 'float', nullable: true)]
    private ?float $valeurPointsKg = null;

    #[ORM\Column(name: 'description_tri', type: 'string', length: 255, nullable: true)]
    private ?string $descriptionTri = null;

    /** @var Collection<int, DeclarationDechet> */
    #[ORM\OneToMany(mappedBy: 'typeDechet', targetEntity: DeclarationDechet::class, fetch: 'LAZY')]
    private Collection $declarationDechets;

    public function __construct()
    {
        $this->declarationDechets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
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
