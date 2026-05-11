<?php

namespace App\Entity;

use App\Repository\IndicateurImpactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndicateurImpactRepository::class)]
class IndicateurImpact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;  // ← Changé : int → ?int avec = null

    #[ORM\Column]
    private ?float $totalKgRecoltes = null;

    #[ORM\Column]
    private ?float $co2Evite = null;

    #[ORM\Column]
    private ?\DateTime $dateCalcul = null;

    /**
     * @var Collection<int, ZonePolluee>
     */
    #[ORM\OneToMany(targetEntity: ZonePolluee::class, mappedBy: 'indicateur')]
    private Collection $zonePolluees;

    public function __construct()
    {
        $this->zonePolluees = new ArrayCollection();
    }

    public function getId(): ?int  // ← Changé : int → ?int
    {
        return $this->id;
    }

    public function getTotalKgRecoltes(): ?float
    {
        return $this->totalKgRecoltes;
    }

    public function setTotalKgRecoltes(float $totalKgRecoltes): static
    {
        $this->totalKgRecoltes = $totalKgRecoltes;

        return $this;
    }

    public function getCo2Evite(): ?float
    {
        return $this->co2Evite;
    }

    public function setCo2Evite(float $co2Evite): static
    {
        $this->co2Evite = $co2Evite;

        return $this;
    }

    public function getDateCalcul(): ?\DateTime
    {
        return $this->dateCalcul;
    }

    public function setDateCalcul(\DateTime $dateCalcul): static
    {
        $this->dateCalcul = $dateCalcul;

        return $this;
    }

    /**
     * @return Collection<int, ZonePolluee>
     */
    public function getZonePolluees(): Collection
    {
        return $this->zonePolluees;
    }

    public function addZonePolluee(ZonePolluee $zonePolluee): static
    {
        if (!$this->zonePolluees->contains($zonePolluee)) {
            $this->zonePolluees->add($zonePolluee);
            $zonePolluee->setIndicateur($this);
        }

        return $this;
    }

    public function removeZonePolluee(ZonePolluee $zonePolluee): static
    {
        if ($this->zonePolluees->removeElement($zonePolluee)) {
            if ($zonePolluee->getIndicateur() === $this) {
                $zonePolluee->setIndicateur(null);
            }
        }

        return $this;
    }
}