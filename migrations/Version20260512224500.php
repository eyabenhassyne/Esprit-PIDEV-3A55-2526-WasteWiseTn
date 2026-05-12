<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260512224500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Compatibilite schema user: ajoute les colonnes attendues par l application si elles sont absentes';
    }

    public function up(Schema $schema): void
    {
        if (!$this->tableExists('user')) {
            return;
        }

        $this->addUserColumnIfMissing('adresse', 'VARCHAR(255) DEFAULT NULL');
        $this->addUserColumnIfMissing('photo_profil', 'VARCHAR(255) DEFAULT NULL');
        $this->addUserColumnIfMissing('notify_validation', 'TINYINT(1) NOT NULL DEFAULT 1');
        $this->addUserColumnIfMissing('notify_points', 'TINYINT(1) NOT NULL DEFAULT 1');
        $this->addUserColumnIfMissing('notify_refus', 'TINYINT(1) NOT NULL DEFAULT 1');
        $this->addUserColumnIfMissing('notify_nouvelles_declarations', 'TINYINT(1) NOT NULL DEFAULT 1');
        $this->addUserColumnIfMissing('langue', "VARCHAR(10) NOT NULL DEFAULT 'fr'");
        $this->addUserColumnIfMissing('theme', "VARCHAR(20) NOT NULL DEFAULT 'clair'");
        $this->addUserColumnIfMissing('unite_preferee', "VARCHAR(20) NOT NULL DEFAULT 'kg'");
        $this->addUserColumnIfMissing('date_inscription', 'DATETIME DEFAULT NULL');
        $this->addUserColumnIfMissing('derniere_connexion', 'DATETIME DEFAULT NULL');
        $this->addUserColumnIfMissing('statut_centre', "VARCHAR(20) NOT NULL DEFAULT 'ACTIF'");
        $this->addUserColumnIfMissing('capacite_max_journaliere', 'DECIMAL(10,2) DEFAULT NULL');
        $this->addUserColumnIfMissing('organisation_centre', 'VARCHAR(255) DEFAULT NULL');
        $this->addUserColumnIfMissing('zone_couverture', 'VARCHAR(255) DEFAULT NULL');
        $this->addUserColumnIfMissing('types_dechets_acceptes', 'LONGTEXT DEFAULT NULL');
        $this->addUserColumnIfMissing('stripe_connect_account_id', 'VARCHAR(255) DEFAULT NULL');

        if ($this->columnExists('user', 'face_embedding') && $this->columnExists('user', 'types_dechets_acceptes')) {
            $this->addSql('UPDATE `user` SET types_dechets_acceptes = face_embedding WHERE types_dechets_acceptes IS NULL AND face_embedding IS NOT NULL');
        }
    }

    public function down(Schema $schema): void
    {
        // no-op
    }

    private function addUserColumnIfMissing(string $column, string $sqlDefinition): void
    {
        if ($this->columnExists('user', $column)) {
            return;
        }

        $this->addSql(sprintf('ALTER TABLE `user` ADD `%s` %s', $column, $sqlDefinition));
    }

    private function tableExists(string $table): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table',
            ['table' => $table]
        );

        return (int) $count > 0;
    }

    private function columnExists(string $table, string $column): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column',
            ['table' => $table, 'column' => $column]
        );

        return (int) $count > 0;
    }
}
