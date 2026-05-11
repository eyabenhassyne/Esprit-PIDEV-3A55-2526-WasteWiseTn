<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260212031121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zone_polluee DROP FOREIGN KEY FK_6CC8C39BDA3B8F3D');
        $this->addSql('ALTER TABLE zone_polluee ADD CONSTRAINT FK_6CC8C39BDA3B8F3D FOREIGN KEY (indicateur_id) REFERENCES indicateur_impact (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zone_polluee DROP FOREIGN KEY FK_6CC8C39BDA3B8F3D');
        $this->addSql('ALTER TABLE zone_polluee ADD CONSTRAINT FK_6CC8C39BDA3B8F3D FOREIGN KEY (indicateur_id) REFERENCES indicateur_impact (id)');
    }
}
