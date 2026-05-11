<?php

namespace App\Entity;

use App\Repository\QRScanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QRScanRepository::class)]
class QRScan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'qRScans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ZonePolluee $zone = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $scannedAt = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $deviceType = null;

    #[ORM\Column(length: 50)]
    private ?string $ipAddress = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getZone(): ?ZonePolluee
    {
        return $this->zone;
    }

    public function setZone(?ZonePolluee $zone): static
    {
        $this->zone = $zone;
        return $this;
    }

    public function getScannedAt(): ?\DateTime
    {
        return $this->scannedAt;
    }

    public function setScannedAt(\DateTime $scannedAt): static
    {
        $this->scannedAt = $scannedAt;
        return $this;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(?string $deviceType): static
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }
}