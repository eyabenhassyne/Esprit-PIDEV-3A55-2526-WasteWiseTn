<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260501223513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Align the reponse_offre foreign key name with the Symfony mapping without touching shared pidev tables.';
    }

    public function up(Schema $schema): void
    {
        $legacyConstraint = $this->connection->fetchOne(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = 'reponse_offre'
               AND CONSTRAINT_NAME = 'fk_reponse_offre_appel'"
        );

        $expectedConstraint = $this->connection->fetchOne(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = 'reponse_offre'
               AND CONSTRAINT_NAME = 'FK_406FFD0C308E35F8'"
        );

        if ($legacyConstraint && !$expectedConstraint) {
            $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY `fk_reponse_offre_appel`');
            $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT FK_406FFD0C308E35F8 FOREIGN KEY (appel_offre_id) REFERENCES appel_offre (id) ON DELETE CASCADE');
        }
    }

    public function down(Schema $schema): void
    {
        $expectedConstraint = $this->connection->fetchOne(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = 'reponse_offre'
               AND CONSTRAINT_NAME = 'FK_406FFD0C308E35F8'"
        );

        $legacyConstraint = $this->connection->fetchOne(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = 'reponse_offre'
               AND CONSTRAINT_NAME = 'fk_reponse_offre_appel'"
        );

        if ($expectedConstraint && !$legacyConstraint) {
            $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C308E35F8');
            $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT `fk_reponse_offre_appel` FOREIGN KEY (appel_offre_id) REFERENCES appel_offre (id) ON DELETE CASCADE ON UPDATE CASCADE');
        }
    }
}
