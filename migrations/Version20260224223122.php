<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260224223122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix QRScan table structure';
    }

    public function up(Schema $schema): void
    {
        // Drop foreign key first
        $this->addSql('ALTER TABLE qr_scan DROP FOREIGN KEY FK_1759A0DA9F2C3FAB');
        
        // Modify the column
        $this->addSql('ALTER TABLE qr_scan CHANGE zone_id zone_id INT NOT NULL');
        
        // Re-add foreign key
        $this->addSql('ALTER TABLE qr_scan ADD CONSTRAINT FK_1759A0DA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_polluee (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE qr_scan DROP FOREIGN KEY FK_1759A0DA9F2C3FAB');
        $this->addSql('ALTER TABLE qr_scan CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qr_scan ADD CONSTRAINT FK_1759A0DA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_polluee (id)');
    }
}