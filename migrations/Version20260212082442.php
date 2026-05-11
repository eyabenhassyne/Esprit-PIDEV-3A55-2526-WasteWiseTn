<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260212082442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE declaration_dechet (id INT AUTO_INCREMENT NOT NULL, id_declaration INT NOT NULL, description VARCHAR(255) NOT NULL, localisation INT NOT NULL, statut VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, quantite DOUBLE PRECISION NOT NULL, unite VARCHAR(255) NOT NULL, created_at DATE NOT NULL, type_dechet_id INT NOT NULL, INDEX IDX_71D10FB6B93D2352 (type_dechet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_dechet (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, valeur_points_kg DOUBLE PRECISION NOT NULL, description_tri VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_71D10FB6B93D2352 FOREIGN KEY (type_dechet_id) REFERENCES type_dechet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY FK_71D10FB6B93D2352');
        $this->addSql('DROP TABLE declaration_dechet');
        $this->addSql('DROP TABLE type_dechet');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
