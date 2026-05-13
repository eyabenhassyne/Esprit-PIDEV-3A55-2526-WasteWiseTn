<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Fix valorisateur table:
 *  - The original migration created column `nom_societé` (with accent é).
 *  - The Doctrine entity maps it as `nom_societe` (no accent) via #[ORM\Column(name: 'nom_societe')].
 *  - This migration renames the accented column to the correct name, and adds any other missing columns.
 */
final class Version20260513120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix valorisateur table: rename nom_societé → nom_societe and add missing columns';
    }

    public function up(Schema $schema): void
    {
        // ── Case 1: table does not exist at all ──────────────────────────────
        if (!$this->tableExists('valorisateur')) {
            $this->addSql('
                CREATE TABLE valorisateur (
                    id          INT AUTO_INCREMENT NOT NULL,
                    nom_societe VARCHAR(255) NOT NULL DEFAULT \'\',
                    email       VARCHAR(255) NOT NULL DEFAULT \'\',
                    telephone   VARCHAR(255) DEFAULT NULL,
                    adresse     VARCHAR(255) DEFAULT NULL,
                    PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
            ');
            return;
        }

        // ── Case 2: table exists with accented column `nom_societé` ──────────
        // Rename it to `nom_societe` (no accent) to match the entity mapping.
        if ($this->columnExists('valorisateur', 'nom_societé') &&
            !$this->columnExists('valorisateur', 'nom_societe')) {
            $this->addSql(
                "ALTER TABLE `valorisateur` CHANGE `nom_societé` `nom_societe` VARCHAR(255) NOT NULL DEFAULT ''"
            );
        }

        // ── Case 3: neither column exists — add it fresh ─────────────────────
        $this->addColumnIfMissing('valorisateur', 'nom_societe', "VARCHAR(255) NOT NULL DEFAULT ''");

        // ── Ensure other expected columns exist ──────────────────────────────
        $this->addColumnIfMissing('valorisateur', 'email',     "VARCHAR(255) NOT NULL DEFAULT ''");
        $this->addColumnIfMissing('valorisateur', 'telephone', 'VARCHAR(255) DEFAULT NULL');
        $this->addColumnIfMissing('valorisateur', 'adresse',   'VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Reverse: rename nom_societe back to nom_societé
        if ($this->tableExists('valorisateur') &&
            $this->columnExists('valorisateur', 'nom_societe')) {
            $this->addSql(
                "ALTER TABLE `valorisateur` CHANGE `nom_societe` `nom_societé` VARCHAR(255) NOT NULL DEFAULT ''"
            );
        }
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function tableExists(string $table): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t',
            ['t' => $table]
        );

        return (int) $count > 0;
    }

    private function columnExists(string $table, string $column): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c',
            ['t' => $table, 'c' => $column]
        );

        return (int) $count > 0;
    }

    private function addColumnIfMissing(string $table, string $column, string $definition): void
    {
        if ($this->columnExists($table, $column)) {
            return;
        }

        $this->addSql(sprintf(
            'ALTER TABLE `%s` ADD `%s` %s',
            $table,
            $column,
            $definition
        ));
    }
}
