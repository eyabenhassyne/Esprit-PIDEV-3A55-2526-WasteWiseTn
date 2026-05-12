<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260304113000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Passe declaration_dechet.created_at en DATETIME pour supporter les regles anti-doublon a la minute';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet MODIFY created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet MODIFY created_at DATE NOT NULL');
    }
}
