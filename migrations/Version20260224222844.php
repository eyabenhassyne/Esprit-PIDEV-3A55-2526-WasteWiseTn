<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224222844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrscan CHANGE device_type device_type VARCHAR(50) DEFAULT NULL, CHANGE ip_address ip_address VARCHAR(50) NOT NULL, CHANGE country country VARCHAR(100) DEFAULT NULL, CHANGE zone_id zone_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrscan CHANGE device_type device_type VARCHAR(255) NOT NULL, CHANGE ip_address ip_address VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE zone_id zone_id INT DEFAULT NULL');
    }
}
