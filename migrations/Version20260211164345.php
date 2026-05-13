<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260211164345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appel_offre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, quantite_demandee DOUBLE PRECISION NOT NULL, date_limite DATETIME NOT NULL, valorisateur_id INT NOT NULL, INDEX IDX_BC56FD475BE119DC (valorisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE citoyen (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(30) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reponse_offre (id INT AUTO_INCREMENT NOT NULL, quantite_proposee DOUBLE PRECISION NOT NULL, date_soumis DATETIME NOT NULL, statut VARCHAR(30) NOT NULL, message LONGTEXT DEFAULT NULL, appel_offre_id INT NOT NULL, citoyen_id INT NOT NULL, INDEX IDX_406FFD0C308E35F8 (appel_offre_id), INDEX IDX_406FFD0C43787BBA (citoyen_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE valorisateur (id INT AUTO_INCREMENT NOT NULL, nom_societé VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE appel_offre ADD CONSTRAINT FK_BC56FD475BE119DC FOREIGN KEY (valorisateur_id) REFERENCES valorisateur (id)');
        $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT FK_406FFD0C308E35F8 FOREIGN KEY (appel_offre_id) REFERENCES appel_offre (id)');
        $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT FK_406FFD0C43787BBA FOREIGN KEY (citoyen_id) REFERENCES citoyen (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appel_offre DROP FOREIGN KEY FK_BC56FD475BE119DC');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C308E35F8');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C43787BBA');
        $this->addSql('DROP TABLE appel_offre');
        $this->addSql('DROP TABLE citoyen');
        $this->addSql('DROP TABLE reponse_offre');
        $this->addSql('DROP TABLE valorisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
