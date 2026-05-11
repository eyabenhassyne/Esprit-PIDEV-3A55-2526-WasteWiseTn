<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260228154000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du cycle de vie admin sur declaration_dechet (valorisateur/date/historique/suppression logique)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet ADD valorisateur_confirmateur_id INT DEFAULT NULL, ADD date_confirmation DATETIME DEFAULT NULL, ADD statut_historique JSON DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_DECLARATION_VALORISATEUR ON declaration_dechet (valorisateur_confirmateur_id)');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_DECLARATION_VALORISATEUR FOREIGN KEY (valorisateur_confirmateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY FK_DECLARATION_VALORISATEUR');
        $this->addSql('DROP INDEX IDX_DECLARATION_VALORISATEUR ON declaration_dechet');
        $this->addSql('ALTER TABLE declaration_dechet DROP valorisateur_confirmateur_id, DROP date_confirmation, DROP statut_historique, DROP deleted_at');
    }
}
