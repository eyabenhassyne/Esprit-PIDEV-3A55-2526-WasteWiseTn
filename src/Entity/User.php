<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`user`', indexes: [
    new ORM\Index(name: 'idx_user_statut_centre', columns: ['statut_centre']),
    new ORM\Index(name: 'idx_user_date_inscription', columns: ['date_inscription']),
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 0;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    /** @var list<string> */
    #[ORM\Column(type: 'json', nullable: false)]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $photoProfil = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $notifyValidation = true;

    #[ORM\Column(options: ['default' => true])]
    private bool $notifyPoints = true;

    #[ORM\Column(options: ['default' => true])]
    private bool $notifyRefus = true;

    #[ORM\Column(options: ['default' => true])]
    private bool $notifyNouvellesDeclarations = true;

    #[ORM\Column(length: 10, options: ['default' => 'fr'])]
    private string $langue = 'fr';

    #[ORM\Column(length: 20, options: ['default' => 'clair'])]
    private string $theme = 'clair';

    #[ORM\Column(length: 20, options: ['default' => 'kg'])]
    private string $unitePreferee = 'kg';

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $derniereConnexion = null;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'ACTIF'])]
    private string $statutCentre = 'ACTIF';

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $capaciteMaxJournaliere = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $organisationCentre = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zoneCouverture = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $typesDechetsAcceptes = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stripeConnectAccountId = null;

    /** @var Collection<int, DeclarationDechet> */
    #[ORM\OneToMany(mappedBy: 'citoyen', targetEntity: DeclarationDechet::class, fetch: 'LAZY')]
    private Collection $declarations;

    #[ORM\OneToOne(mappedBy: 'utilisateur', targetEntity: Wallet::class, fetch: 'LAZY')]
    private ?Wallet $wallet = null;

    /** @var Collection<int, BonAchat> */
    #[ORM\OneToMany(mappedBy: 'partenaire', targetEntity: BonAchat::class, fetch: 'LAZY')]
    private Collection $bonsAchat;

    /** @var Collection<int, BadgePartenaire> */
    #[ORM\OneToMany(
        mappedBy: 'partenaire',
        targetEntity: BadgePartenaire::class,
        fetch: 'LAZY',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $badgesPartenaire;

    public function __construct()
    {
        $this->declarations = new ArrayCollection();
        $this->bonsAchat = new ArrayCollection();
        $this->badgesPartenaire = new ArrayCollection();
        $this->dateInscription = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id > 0 ? $this->id : null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(?string $photoProfil): static
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function isNotifyValidation(): bool
    {
        return $this->notifyValidation;
    }

    public function setNotifyValidation(bool $notifyValidation): static
    {
        $this->notifyValidation = $notifyValidation;

        return $this;
    }

    public function isNotifyPoints(): bool
    {
        return $this->notifyPoints;
    }

    public function setNotifyPoints(bool $notifyPoints): static
    {
        $this->notifyPoints = $notifyPoints;

        return $this;
    }

    public function isNotifyRefus(): bool
    {
        return $this->notifyRefus;
    }

    public function setNotifyRefus(bool $notifyRefus): static
    {
        $this->notifyRefus = $notifyRefus;

        return $this;
    }

    public function isNotifyNouvellesDeclarations(): bool
    {
        return $this->notifyNouvellesDeclarations;
    }

    public function setNotifyNouvellesDeclarations(bool $notifyNouvellesDeclarations): static
    {
        $this->notifyNouvellesDeclarations = $notifyNouvellesDeclarations;

        return $this;
    }

    public function getLangue(): string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): static
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getUnitePreferee(): string
    {
        return $this->unitePreferee;
    }

    public function setUnitePreferee(string $unitePreferee): static
    {
        $this->unitePreferee = $unitePreferee;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription(?\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription === null
            ? null
            : ($dateInscription instanceof \DateTimeImmutable
                ? $dateInscription
                : \DateTimeImmutable::createFromMutable($dateInscription));

        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeImmutable
    {
        return $this->derniereConnexion;
    }

    public function setDerniereConnexion(?\DateTimeInterface $derniereConnexion): static
    {
        $this->derniereConnexion = $derniereConnexion === null
            ? null
            : ($derniereConnexion instanceof \DateTimeImmutable
                ? $derniereConnexion
                : \DateTimeImmutable::createFromMutable($derniereConnexion));

        return $this;
    }

    public function getStatutCentre(): string
    {
        return $this->statutCentre;
    }

    public function setStatutCentre(string $statutCentre): static
    {
        $this->statutCentre = $statutCentre;

        return $this;
    }

    public function getCapaciteMaxJournaliere(): ?float
    {
        return $this->capaciteMaxJournaliere !== null ? (float) $this->capaciteMaxJournaliere : null;
    }

    public function setCapaciteMaxJournaliere(?float $capaciteMaxJournaliere): static
    {
        $this->capaciteMaxJournaliere = $capaciteMaxJournaliere !== null ? number_format($capaciteMaxJournaliere, 2, '.', '') : null;

        return $this;
    }

    public function getOrganisationCentre(): ?string
    {
        return $this->organisationCentre;
    }

    public function setOrganisationCentre(?string $organisationCentre): static
    {
        $this->organisationCentre = $organisationCentre;

        return $this;
    }

    public function getZoneCouverture(): ?string
    {
        return $this->zoneCouverture;
    }

    public function setZoneCouverture(?string $zoneCouverture): static
    {
        $this->zoneCouverture = $zoneCouverture;

        return $this;
    }

    public function getTypesDechetsAcceptes(): ?string
    {
        return $this->typesDechetsAcceptes;
    }

    public function setTypesDechetsAcceptes(?string $typesDechetsAcceptes): static
    {
        $this->typesDechetsAcceptes = $typesDechetsAcceptes;

        return $this;
    }

    public function getStripeConnectAccountId(): ?string
    {
        return $this->stripeConnectAccountId;
    }

    public function setStripeConnectAccountId(?string $stripeConnectAccountId): static
    {
        $this->stripeConnectAccountId = $stripeConnectAccountId;

        return $this;
    }

    /**
     * @return Collection<int, DeclarationDechet>
     */
    public function getDeclarations(): Collection
    {
        return $this->declarations;
    }

    public function addDeclaration(DeclarationDechet $declaration): static
    {
        if (!$this->declarations->contains($declaration)) {
            $this->declarations->add($declaration);
            $declaration->setCitoyen($this);
        }

        return $this;
    }

    public function removeDeclaration(DeclarationDechet $declaration): static
    {
        if ($this->declarations->removeElement($declaration)) {
            if ($declaration->getCitoyen() === $this) {
                $declaration->setCitoyen(null);
            }
        }

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): static
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return Collection<int, BonAchat>
     */
    public function getBonsAchat(): Collection
    {
        return $this->bonsAchat;
    }

    public function addBonAchat(BonAchat $bonAchat): static
    {
        if (!$this->bonsAchat->contains($bonAchat)) {
            $this->bonsAchat->add($bonAchat);
            $bonAchat->setPartenaire($this);
        }

        return $this;
    }

    public function removeBonAchat(BonAchat $bonAchat): static
    {
        if ($this->bonsAchat->removeElement($bonAchat)) {
            if ($bonAchat->getPartenaire() === $this) {
                $bonAchat->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BadgePartenaire>
     */
    public function getBadgesPartenaire(): Collection
    {
        return $this->badgesPartenaire;
    }

    public function addBadgePartenaire(BadgePartenaire $badgePartenaire): static
    {
        if (!$this->badgesPartenaire->contains($badgePartenaire)) {
            $this->badgesPartenaire->add($badgePartenaire);
            $badgePartenaire->setPartenaire($this);
        }

        return $this;
    }

    public function removeBadgePartenaire(BadgePartenaire $badgePartenaire): static
    {
        if ($this->badgesPartenaire->removeElement($badgePartenaire)) {
            if ($badgePartenaire->getPartenaire() === $this) {
                $badgePartenaire->setPartenaire(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function ensureDateInscription(): void
    {
        if ($this->dateInscription === null) {
            $this->dateInscription = new \DateTimeImmutable();
        }
    }
}
