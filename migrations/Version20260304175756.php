<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304175756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_token (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(100) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, used_at DATETIME DEFAULT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_452C9EC55F37A13B (token), INDEX IDX_452C9EC5A76ED395 (user_id), INDEX idx_reset_token (token), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(120) NOT NULL, prenom VARCHAR(120) NOT NULL, telephone VARCHAR(30) DEFAULT NULL, type VARCHAR(20) DEFAULT \'CITIZEN\' NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT DEFAULT 1 NOT NULL, face_embedding JSON DEFAULT NULL, face_updated_at DATETIME DEFAULT NULL, last_seen_at DATETIME DEFAULT NULL, google_authenticator_secret VARCHAR(128) DEFAULT NULL, is_two_factor_enabled TINYINT DEFAULT 0 NOT NULL, UNIQUE INDEX uniq_user_email (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE reset_password_token ADD CONSTRAINT FK_452C9EC5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_token DROP FOREIGN KEY FK_452C9EC5A76ED395');
        $this->addSql('DROP TABLE reset_password_token');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
