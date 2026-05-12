<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260212100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cree les tables coeur manquantes (user, wallet, wallet_transaction) et complete declaration_dechet';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
CREATE TABLE IF NOT EXISTS `user` (
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(180) NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(255) DEFAULT NULL,
    prenom VARCHAR(255) DEFAULT NULL,
    adresse VARCHAR(255) DEFAULT NULL,
    notify_refus TINYINT(1) NOT NULL DEFAULT 1,
    unite_preferee VARCHAR(20) NOT NULL DEFAULT 'kg',
    date_inscription DATETIME DEFAULT NULL,
    derniere_connexion DATETIME DEFAULT NULL,
    UNIQUE INDEX UNIQ_8D93D649E7927C74 (email),
    INDEX idx_user_date_inscription (date_inscription),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
SQL);

        $this->addSql(<<<'SQL'
CREATE TABLE IF NOT EXISTS wallet (
    id_wallet INT AUTO_INCREMENT NOT NULL,
    utilisateur_id INT NOT NULL,
    solde_actuel INT NOT NULL DEFAULT 0,
    date_mj DATETIME NOT NULL,
    UNIQUE INDEX UNIQ_WALLET_UTILISATEUR (utilisateur_id),
    PRIMARY KEY(id_wallet)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
SQL);

        $this->addSql(<<<'SQL'
CREATE TABLE IF NOT EXISTS wallet_transaction (
    id_transaction INT AUTO_INCREMENT NOT NULL,
    wallet_id INT NOT NULL,
    montant INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    motif VARCHAR(255) NOT NULL,
    date_transaction DATETIME NOT NULL,
    INDEX idx_transaction_wallet (wallet_id),
    INDEX idx_transaction_date (date_transaction),
    INDEX idx_transaction_type (type),
    PRIMARY KEY(id_transaction)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
SQL);

        $this->addSql('ALTER TABLE declaration_dechet MODIFY statut VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechet MODIFY unite VARCHAR(16) NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechet ADD COLUMN IF NOT EXISTS score_ia DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_dechet ADD COLUMN IF NOT EXISTS points_attribues INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE declaration_dechet ADD COLUMN IF NOT EXISTS qr_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_dechet ADD COLUMN IF NOT EXISTS citoyen_id INT DEFAULT NULL');

        if (!$this->constraintExists('FK_WALLET_USER')) {
            $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_WALLET_USER FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        }

        if (!$this->constraintExists('FK_TRANSACTION_WALLET')) {
            $this->addSql('ALTER TABLE wallet_transaction ADD CONSTRAINT FK_TRANSACTION_WALLET FOREIGN KEY (wallet_id) REFERENCES wallet (id_wallet)');
        }

        if (!$this->constraintExists('FK_DECLARATION_CITOYEN')) {
            $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_DECLARATION_CITOYEN FOREIGN KEY (citoyen_id) REFERENCES `user` (id)');
        }
    }

    public function down(Schema $schema): void
    {
        // No-op: migration de fond utilisee pour remettre une chronologie coherente.
    }

    private function constraintExists(string $constraintName): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND CONSTRAINT_NAME = :name',
            ['name' => $constraintName]
        );

        return (int) $count > 0;
    }
}
