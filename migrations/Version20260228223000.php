<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260228223000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout module partenaire business (bon_achat + badge_partenaire)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bon_achat (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, nom_magasin VARCHAR(255) NOT NULL, logo_magasin VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, valeur_monetaire DOUBLE PRECISION NOT NULL, points_requis INT NOT NULL, date_debut DATE NOT NULL, date_expiration DATE NOT NULL, nombre_maximum_utilisations INT NOT NULL, nombre_utilisations INT NOT NULL, conditions_utilisation LONGTEXT DEFAULT NULL, zone_geographique VARCHAR(255) DEFAULT NULL, image_promotionnelle VARCHAR(255) DEFAULT NULL, statut VARCHAR(32) NOT NULL, historique_modifications JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BON_ACHAT_PARTENAIRE (partenaire_id), INDEX IDX_BON_ACHAT_STATUT (statut), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge_partenaire (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, code VARCHAR(50) NOT NULL, nom VARCHAR(120) NOT NULL, description VARCHAR(255) NOT NULL, couleur VARCHAR(12) NOT NULL, icone VARCHAR(50) NOT NULL, score_impact INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_current TINYINT(1) NOT NULL, INDEX IDX_BADGE_PARTENAIRE_USER (partenaire_id), INDEX IDX_BADGE_PARTENAIRE_CURRENT (is_current), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bon_achat ADD CONSTRAINT FK_BON_ACHAT_PARTENAIRE FOREIGN KEY (partenaire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE badge_partenaire ADD CONSTRAINT FK_BADGE_PARTENAIRE_USER FOREIGN KEY (partenaire_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE badge_partenaire DROP FOREIGN KEY FK_BADGE_PARTENAIRE_USER');
        $this->addSql('ALTER TABLE bon_achat DROP FOREIGN KEY FK_BON_ACHAT_PARTENAIRE');
        $this->addSql('DROP TABLE badge_partenaire');
        $this->addSql('DROP TABLE bon_achat');
    }
}
