<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'uniq_user_email', columns: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    public const TYPE_CITIZEN   = 'CITIZEN';
    public const TYPE_VALORIZER = 'VALORIZER';
    public const TYPE_ADMIN     = 'ADMIN';
    public const TYPE_PARTNER   = 'PARTNER'; // Γ£à pour PromoteUserRoleCommand.php

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    /** @phpstan-ignore-next-line Doctrine assigne l'id ├á l'hydratation */
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180)]
    private ?string $email = null;

    /**
     * @var list<string>
     */
    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::STRING, length: 120)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::STRING, length: 120)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::STRING, length: 30, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: Types::STRING, length: 20, options: ['default' => self::TYPE_CITIZEN])]
    private string $type = self::TYPE_CITIZEN;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $isActive = true;

    // Γ£à V├⌐rification email (pour SymfonyCasts VerifyEmail)
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isVerified = false;

    /**
     * @var list<float>|null
     */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $faceEmbedding = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $faceUpdatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $lastSeenAt = null;

    // 2FA (Scheb)
    #[ORM\Column(type: Types::STRING, length: 128, nullable: true)]
    private ?string $googleAuthenticatorSecret = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isTwoFactorEnabled = false;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isActive = true;
        $this->isVerified = false;
        $this->isTwoFactorEnabled = false;
    }

    public function __toString(): string
    {
        return (string) ($this->email ?? '');
    }

    // =========================
    // Γ£à Identit├⌐ / Security
    // =========================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = mb_strtolower(trim($email));
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) ($this->email ?? '');
    }

    // compat ancien code
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // toujours ROLE_USER
        $roles[] = 'ROLE_USER';

        // r├┤le bas├⌐ sur type
        $roles[] = match ($this->type) {
            self::TYPE_ADMIN     => 'ROLE_ADMIN',
            self::TYPE_VALORIZER => 'ROLE_VALORIZER',
            self::TYPE_PARTNER   => 'ROLE_PARTNER',
            default              => 'ROLE_CITIZEN',
        };

        /** @var list<string> $unique */
        $unique = array_values(array_unique($roles));
        return $unique;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): self
    {
        // comme $roles est list<string>, is_string() serait ΓÇ£toujours vraiΓÇ¥
        $roles = array_values(array_filter($roles, static fn (string $r): bool => $r !== ''));
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return (string) ($this->password ?? '');
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // rien
    }

    // =========================
    // Γ£à Profil
    // =========================

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom !== null ? trim($nom) : null;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom !== null ? trim($prenom) : null;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone !== null ? trim($telephone) : null;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $allowed = [self::TYPE_CITIZEN, self::TYPE_VALORIZER, self::TYPE_ADMIN, self::TYPE_PARTNER];
        $this->type = in_array($type, $allowed, true) ? $type : self::TYPE_CITIZEN;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    // =========================
    // Γ£à Activation
    // =========================

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    // =========================
    // Γ£à V├⌐rification email
    // =========================

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    // =========================
    // Γ£à Derni├¿re activit├⌐
    // =========================

    public function getLastSeenAt(): ?\DateTimeImmutable
    {
        return $this->lastSeenAt;
    }

    public function setLastSeenAt(?\DateTimeImmutable $lastSeenAt): self
    {
        $this->lastSeenAt = $lastSeenAt;
        return $this;
    }

    // =========================
    // Γ£à Face Embedding
    // =========================

    /**
     * @return list<float>|null
     */
    public function getFaceEmbedding(): ?array
    {
        return $this->faceEmbedding;
    }

    /**
     * @param list<float>|null $faceEmbedding
     */
    public function setFaceEmbedding(?array $faceEmbedding): self
    {
        if ($faceEmbedding === null) {
            $this->faceEmbedding = null;
            $this->faceUpdatedAt = null;
            return $this;
        }

        $clean = [];
        foreach ($faceEmbedding as $v) {
            $f = (float) $v;
            if (!is_finite($f)) {
                continue;
            }
            $clean[] = $f;
        }

        if (count($clean) < 64) {
            $this->faceEmbedding = null;
            $this->faceUpdatedAt = null;
            return $this;
        }

        $this->faceEmbedding = $clean;
        $this->faceUpdatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function hasFaceEmbedding(int $minSize = 64): bool
    {
        return is_array($this->faceEmbedding) && count($this->faceEmbedding) >= $minSize;
    }

    public function clearFaceEmbedding(): self
    {
        $this->faceEmbedding = null;
        $this->faceUpdatedAt = null;
        return $this;
    }

    public function getFaceUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->faceUpdatedAt;
    }

    public function setFaceUpdatedAt(?\DateTimeImmutable $faceUpdatedAt): self
    {
        $this->faceUpdatedAt = $faceUpdatedAt;
        return $this;
    }

    // =========================
    // Γ£à Helpers r├┤le (affichage)
    // =========================

    /**
     * @return array<string,string>
     */
    public static function getRoleLabels(): array
    {
        return [
            'ROLE_ADMIN'     => 'Admin',
            'ROLE_VALORIZER' => 'Valorisateur',
            'ROLE_PARTNER'   => 'Partenaire',
            'ROLE_CITIZEN'   => 'Citoyen',
            'ROLE_USER'      => 'Utilisateur',
        ];
    }

    public function getPrimaryRole(): string
    {
        return match ($this->type) {
            self::TYPE_ADMIN     => 'Admin',
            self::TYPE_VALORIZER => 'Valorisateur',
            self::TYPE_PARTNER   => 'Partenaire',
            default              => 'Citoyen',
        };
    }

    public function getRoleLabel(): string
    {
        return $this->getPrimaryRole();
    }

    // =========================
    // Γ£à 2FA Google Authenticator (Scheb)
    // =========================

    public function isGoogleAuthenticatorEnabled(): bool
    {
        // obligatoire pour citoyen/valorisateur uniquement
        if (!in_array($this->type, [self::TYPE_CITIZEN, self::TYPE_VALORIZER], true)) {
            return false;
        }

        // activ├⌐ seulement si flag ON + secret pr├⌐sent
        return $this->isTwoFactorEnabled && !empty($this->googleAuthenticatorSecret);
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->getEmail() ?? '';
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $secret): self
    {
        $this->googleAuthenticatorSecret = $secret;
        return $this;
    }

    public function isTwoFactorEnabled(): bool
    {
        return $this->isTwoFactorEnabled;
    }

    public function setIsTwoFactorEnabled(bool $enabled): self
    {
        $this->isTwoFactorEnabled = $enabled;
        return $this;
    }
}
