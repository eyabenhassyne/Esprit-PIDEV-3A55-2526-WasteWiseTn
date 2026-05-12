<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511181900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE indicateur_impact (id INT AUTO_INCREMENT NOT NULL, total_kg_recoltes DOUBLE PRECISION NOT NULL, co2_evite DOUBLE PRECISION NOT NULL, date_calcul DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE qrscan (id INT AUTO_INCREMENT NOT NULL, scanned_at DATETIME NOT NULL, device_type VARCHAR(50) DEFAULT NULL, ip_address VARCHAR(50) NOT NULL, country VARCHAR(100) DEFAULT NULL, zone_id INT NOT NULL, INDEX IDX_1759A0DA9F2C3FAB (zone_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE zone_polluee (id INT AUTO_INCREMENT NOT NULL, nom_zone VARCHAR(255) NOT NULL, coordonnees_gps VARCHAR(255) NOT NULL, niveau_pollution INT NOT NULL, date_identification DATETIME NOT NULL, indicateur_id INT DEFAULT NULL, INDEX IDX_6CC8C39BDA3B8F3D (indicateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE qrscan ADD CONSTRAINT FK_1759A0DA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_polluee (id)');
        $this->addSql('ALTER TABLE zone_polluee ADD CONSTRAINT FK_6CC8C39BDA3B8F3D FOREIGN KEY (indicateur_id) REFERENCES indicateur_impact (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT FK_406FFD0C308E35F8 FOREIGN KEY (appel_offre_id) REFERENCES appel_offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_offre ADD CONSTRAINT FK_406FFD0C43787BBA FOREIGN KEY (citoyen_id) REFERENCES citoyen (id)');
        $this->addSql('CREATE INDEX IDX_406FFD0C308E35F8 ON reponse_offre (appel_offre_id)');
        $this->addSql('CREATE INDEX IDX_406FFD0C43787BBA ON reponse_offre (citoyen_id)');
        $this->addSql('ALTER TABLE reset_password_token DROP FOREIGN KEY `reset_password_token_ibfk_1`');
        $this->addSql('ALTER TABLE reset_password_token CHANGE token token VARCHAR(100) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('CREATE INDEX idx_reset_token ON reset_password_token (token)');
        $this->addSql('DROP INDEX token ON reset_password_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_452C9EC55F37A13B ON reset_password_token (token)');
        $this->addSql('DROP INDEX user_id ON reset_password_token');
        $this->addSql('CREATE INDEX IDX_452C9EC5A76ED395 ON reset_password_token (user_id)');
        $this->addSql('ALTER TABLE reset_password_token ADD CONSTRAINT `reset_password_token_ibfk_1` FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_dechet DROP id_type');
        $this->addSql('DROP INDEX idx_users_email ON user');
        $this->addSql('DROP INDEX idx_users_type ON user');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE nom nom VARCHAR(120) NOT NULL, CHANGE prenom prenom VARCHAR(120) NOT NULL, CHANGE type type VARCHAR(20) DEFAULT \'CITIZEN\' NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE is_active is_active TINYINT DEFAULT 1 NOT NULL, CHANGE face_embedding face_embedding JSON DEFAULT NULL, CHANGE google_authenticator_secret google_authenticator_secret VARCHAR(128) DEFAULT NULL, CHANGE is_two_factor_enabled is_two_factor_enabled TINYINT DEFAULT 0 NOT NULL, CHANGE is_verified is_verified TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX email ON user');
        $this->addSql('CREATE UNIQUE INDEX uniq_user_email ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrscan DROP FOREIGN KEY FK_1759A0DA9F2C3FAB');
        $this->addSql('ALTER TABLE zone_polluee DROP FOREIGN KEY FK_6CC8C39BDA3B8F3D');
        $this->addSql('DROP TABLE indicateur_impact');
        $this->addSql('DROP TABLE qrscan');
        $this->addSql('DROP TABLE zone_polluee');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C308E35F8');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C43787BBA');
        $this->addSql('DROP INDEX IDX_406FFD0C308E35F8 ON reponse_offre');
        $this->addSql('DROP INDEX IDX_406FFD0C43787BBA ON reponse_offre');
        $this->addSql('DROP INDEX idx_reset_token ON reset_password_token');
        $this->addSql('ALTER TABLE reset_password_token DROP FOREIGN KEY FK_452C9EC5A76ED395');
        $this->addSql('ALTER TABLE reset_password_token CHANGE token token VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('DROP INDEX uniq_452c9ec55f37a13b ON reset_password_token');
        $this->addSql('CREATE UNIQUE INDEX token ON reset_password_token (token)');
        $this->addSql('DROP INDEX idx_452c9ec5a76ed395 ON reset_password_token');
        $this->addSql('CREATE INDEX user_id ON reset_password_token (user_id)');
        $this->addSql('ALTER TABLE reset_password_token ADD CONSTRAINT FK_452C9EC5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_dechet ADD id_type INT NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(150) NOT NULL, CHANGE roles roles TEXT DEFAULT NULL, CHANGE nom nom VARCHAR(100) DEFAULT NULL, CHANGE prenom prenom VARCHAR(100) DEFAULT NULL, CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE is_active is_active TINYINT DEFAULT 1, CHANGE is_verified is_verified TINYINT DEFAULT 0, CHANGE face_embedding face_embedding LONGTEXT DEFAULT NULL, CHANGE google_authenticator_secret google_authenticator_secret VARCHAR(255) DEFAULT NULL, CHANGE is_two_factor_enabled is_two_factor_enabled TINYINT DEFAULT 0');
        $this->addSql('CREATE INDEX idx_users_email ON `user` (email)');
        $this->addSql('CREATE INDEX idx_users_type ON `user` (type)');
        $this->addSql('DROP INDEX uniq_user_email ON `user`');
        $this->addSql('CREATE UNIQUE INDEX email ON `user` (email)');
    }
}
