<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260304121500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Augmente la longueur de declaration_dechet.description a 500 caracteres';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet MODIFY description VARCHAR(500) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE declaration_dechet MODIFY description VARCHAR(255) NOT NULL');
    }
}
