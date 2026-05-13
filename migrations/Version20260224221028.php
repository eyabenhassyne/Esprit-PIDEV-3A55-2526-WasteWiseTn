<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224221028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qrscan (id INT AUTO_INCREMENT NOT NULL, scanned_at DATETIME NOT NULL, device_type VARCHAR(255) NOT NULL, ip_address VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, zone_id INT DEFAULT NULL, INDEX IDX_1759A0DA9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE qrscan ADD CONSTRAINT FK_1759A0DA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_polluee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrscan DROP FOREIGN KEY FK_1759A0DA9F2C3FAB');
        $this->addSql('DROP TABLE qrscan');
    }
}
