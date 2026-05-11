<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260226225000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout des champs profil/metier valorisateur dans la table user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `user` ADD telephone VARCHAR(30) DEFAULT NULL, ADD photo_profil VARCHAR(255) DEFAULT NULL, ADD notify_validation TINYINT(1) NOT NULL DEFAULT 1, ADD notify_points TINYINT(1) NOT NULL DEFAULT 1, ADD notify_nouvelles_declarations TINYINT(1) NOT NULL DEFAULT 1, ADD langue VARCHAR(10) NOT NULL DEFAULT \'fr\', ADD theme VARCHAR(20) NOT NULL DEFAULT \'clair\', ADD statut_centre VARCHAR(20) NOT NULL DEFAULT \'ACTIF\', ADD capacite_max_journaliere INT DEFAULT NULL, ADD organisation_centre VARCHAR(255) DEFAULT NULL, ADD zone_couverture VARCHAR(255) DEFAULT NULL, ADD types_dechets_acceptes LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `user` DROP telephone, DROP photo_profil, DROP notify_validation, DROP notify_points, DROP notify_nouvelles_declarations, DROP langue, DROP theme, DROP statut_centre, DROP capacite_max_journaliere, DROP organisation_centre, DROP zone_couverture, DROP types_dechets_acceptes');
    }
}
