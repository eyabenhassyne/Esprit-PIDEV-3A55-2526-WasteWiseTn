<?php

namespace App\Entity;

use App\Repository\ZonePollueeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZonePollueeRepository::class)]
class ZonePolluee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $nomZone = null;

    #[ORM\Column(length: 255)]
    private ?string $coordonneesGps = null;

    #[ORM\Column(type: "integer")]
    private ?int $niveauPollution = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateIdentification = null;

    #[ORM\ManyToOne(targetEntity: IndicateurImpact::class, inversedBy: "zonePolluees")]
    #[ORM\JoinColumn(name: "indicateur_id", referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    private ?IndicateurImpact $indicateur = null;

    /**
     * @var Collection<int, QRScan>
     */
    #[ORM\OneToMany(targetEntity: QRScan::class, mappedBy: 'zone')]
    private Collection $qRScans;

    public function __construct()
    {
        $this->qRScans = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(string $nomZone): static
    {
        $this->nomZone = $nomZone;
        return $this;
    }

    public function getCoordonneesGps(): ?string
    {
        return $this->coordonneesGps;
    }

    public function setCoordonneesGps(string $coordonneesGps): static
    {
        $this->coordonneesGps = $coordonneesGps;
        return $this;
    }

    public function getNiveauPollution(): ?int
    {
        return $this->niveauPollution;
    }

    public function setNiveauPollution(int $niveauPollution): static
    {
        $this->niveauPollution = $niveauPollution;
        return $this;
    }

    public function getDateIdentification(): ?\DateTimeInterface
    {
        return $this->dateIdentification;
    }

    public function setDateIdentification(?\DateTimeInterface $dateIdentification): static
    {
        $this->dateIdentification = $dateIdentification;
        return $this;
    }

    public function getIndicateur(): ?IndicateurImpact
    {
        return $this->indicateur;
    }

    public function setIndicateur(?IndicateurImpact $indicateur): static
    {
        $this->indicateur = $indicateur;
        return $this;
    }

    /**
     * @return Collection<int, QRScan>
     */
    public function getQRScans(): Collection
    {
        return $this->qRScans;
    }

    public function addQRScan(QRScan $qRScan): static
    {
        if (!$this->qRScans->contains($qRScan)) {
            $this->qRScans->add($qRScan);
            $qRScan->setZone($this);
        }

        return $this;
    }

    public function removeQRScan(QRScan $qRScan): static
    {
        if ($this->qRScans->removeElement($qRScan)) {
            if ($qRScan->getZone() === $this) {
                $qRScan->setZone(null);
            }
        }

        return $this;
    }
}