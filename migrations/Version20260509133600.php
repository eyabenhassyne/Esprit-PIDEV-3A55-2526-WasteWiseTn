<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260509133600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE citoyen (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE valorisateur (id INT AUTO_INCREMENT NOT NULL, nom_societé VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY `declaration_dechet_ibfk_1`');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY `declaration_dechet_ibfk_2`');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY `declaration_dechet_ibfk_3`');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY `participation_ibfk_1`');
        $this->addSql('ALTER TABLE qrscan DROP FOREIGN KEY `qrscan_ibfk_1`');
        $this->addSql('ALTER TABLE reset_password_tokens DROP FOREIGN KEY `fk_reset_user`');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY `wallet_ibfk_1`');
        $this->addSql('ALTER TABLE wallet_transaction DROP FOREIGN KEY `wallet_transaction_ibfk_1`');
        $this->addSql('ALTER TABLE zone_polluee DROP FOREIGN KEY `zone_polluee_ibfk_1`');
        $this->addSql('DROP TABLE badge_partenaire');
        $this->addSql('DROP TABLE bon_achat');
        $this->addSql('DROP TABLE declaration_dechet');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE indicateur_impact');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE qrscan');
        $this->addSql('DROP TABLE reset_password_tokens');
        $this->addSql('DROP TABLE type_dechet');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE wallet_transaction');
        $this->addSql('DROP TABLE zone_polluee');
        $this->addSql('ALTER TABLE appel_offre CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE appel_offre ADD CONSTRAINT FK_BC56FD475BE119DC FOREIGN KEY (valorisateur_id) REFERENCES valorisateur (id)');
        $this->addSql('CREATE INDEX IDX_BC56FD475BE119DC ON appel_offre (valorisateur_id)');
        $this->addSql('ALTER TABLE reponse_offre CHANGE statut statut VARCHAR(30) NOT NULL, CHANGE message message LONGTEXT DEFAULT NULL');
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
        $this->addSql('DROP INDEX idx_users_email ON user');
        $this->addSql('DROP INDEX idx_users_type ON user');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE nom nom VARCHAR(120) NOT NULL, CHANGE prenom prenom VARCHAR(120) NOT NULL, CHANGE type type VARCHAR(20) DEFAULT \'CITIZEN\' NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE is_active is_active TINYINT DEFAULT 1 NOT NULL, CHANGE face_embedding face_embedding JSON DEFAULT NULL, CHANGE google_authenticator_secret google_authenticator_secret VARCHAR(128) DEFAULT NULL, CHANGE is_two_factor_enabled is_two_factor_enabled TINYINT DEFAULT 0 NOT NULL, CHANGE is_verified is_verified TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX email ON user');
        $this->addSql('CREATE UNIQUE INDEX uniq_user_email ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge_partenaire (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, code VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, couleur VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, icone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, score_impact INT DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, is_current TINYINT DEFAULT 1, UNIQUE INDEX code (code), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bon_achat (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, nom_magasin VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, logo_magasin VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, valeur_monetaire DOUBLE PRECISION DEFAULT NULL, points_requis INT DEFAULT 0, date_debut DATE DEFAULT NULL, date_expiration DATE DEFAULT NULL, nombre_maximum_utilisations INT DEFAULT NULL, nombre_utilisations INT DEFAULT 0, conditions_utilisation TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, zone_geographique VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, image_promotionnelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'ACTIF\' COLLATE `utf8mb4_general_ci`, historique_modifications TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE declaration_dechet (id INT AUTO_INCREMENT NOT NULL, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'EN_ATTENTE\' COLLATE `utf8mb4_general_ci`, type_dechet_id INT DEFAULT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, unite VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'kg\' COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, score_ia DOUBLE PRECISION DEFAULT NULL, points_attribues INT DEFAULT 0, qr_code VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, citoyen_id INT DEFAULT NULL, valorisateur_confirmateur_id INT DEFAULT NULL, date_confirmation DATETIME DEFAULT NULL, statut_historique TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, deleted_at DATETIME DEFAULT NULL, INDEX type_dechet_id (type_dechet_id), INDEX citoyen_id (citoyen_id), INDEX valorisateur_confirmateur_id (valorisateur_confirmateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, dateHeure DATETIME DEFAULT NULL, lieu VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, nomOrganisateur VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE indicateur_impact (id INT AUTO_INCREMENT NOT NULL, total_kg_recoltes DOUBLE PRECISION DEFAULT \'0\' NOT NULL, co2_evite DOUBLE PRECISION DEFAULT \'0\' NOT NULL, date_calcul DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, dateInscription DATE DEFAULT NULL, evenement_id INT DEFAULT NULL, nomCitoyen VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX evenement_id (evenement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qrscan (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, scanned_at DATETIME DEFAULT CURRENT_TIMESTAMP, ip_address VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, country VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX zone_id (zone_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reset_password_tokens (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, expires_at DATETIME NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, used_at DATETIME DEFAULT NULL, INDEX idx_token_user (user_id), INDEX idx_token_value (token), UNIQUE INDEX token (token), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_dechet (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, valeur_points_kg DOUBLE PRECISION DEFAULT \'0\', description_tri TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wallet (id_wallet INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, solde_actuel INT DEFAULT 0, date_mj DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX utilisateur_id (utilisateur_id), PRIMARY KEY (id_wallet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wallet_transaction (id_transaction INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, montant INT NOT NULL, type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, motif VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX wallet_id (wallet_id), PRIMARY KEY (id_transaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE zone_polluee (id INT AUTO_INCREMENT NOT NULL, nom_zone VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, coordonnees_gps VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, niveau_pollution INT NOT NULL, date_identification DATETIME DEFAULT CURRENT_TIMESTAMP, indicateur_id INT DEFAULT NULL, INDEX indicateur_id (indicateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT `declaration_dechet_ibfk_1` FOREIGN KEY (type_dechet_id) REFERENCES type_dechet (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT `declaration_dechet_ibfk_2` FOREIGN KEY (citoyen_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT `declaration_dechet_ibfk_3` FOREIGN KEY (valorisateur_confirmateur_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qrscan ADD CONSTRAINT `qrscan_ibfk_1` FOREIGN KEY (zone_id) REFERENCES zone_polluee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_tokens ADD CONSTRAINT `fk_reset_user` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallet_transaction ADD CONSTRAINT `wallet_transaction_ibfk_1` FOREIGN KEY (wallet_id) REFERENCES wallet (id_wallet) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_polluee ADD CONSTRAINT `zone_polluee_ibfk_1` FOREIGN KEY (indicateur_id) REFERENCES indicateur_impact (id) ON DELETE SET NULL');
        $this->addSql('DROP TABLE citoyen');
        $this->addSql('DROP TABLE valorisateur');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE appel_offre DROP FOREIGN KEY FK_BC56FD475BE119DC');
        $this->addSql('DROP INDEX IDX_BC56FD475BE119DC ON appel_offre');
        $this->addSql('ALTER TABLE appel_offre CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C308E35F8');
        $this->addSql('ALTER TABLE reponse_offre DROP FOREIGN KEY FK_406FFD0C43787BBA');
        $this->addSql('DROP INDEX IDX_406FFD0C308E35F8 ON reponse_offre');
        $this->addSql('DROP INDEX IDX_406FFD0C43787BBA ON reponse_offre');
        $this->addSql('ALTER TABLE reponse_offre CHANGE statut statut VARCHAR(50) NOT NULL, CHANGE message message TEXT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_reset_token ON reset_password_token');
        $this->addSql('ALTER TABLE reset_password_token DROP FOREIGN KEY FK_452C9EC5A76ED395');
        $this->addSql('ALTER TABLE reset_password_token CHANGE token token VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('DROP INDEX idx_452c9ec5a76ed395 ON reset_password_token');
        $this->addSql('CREATE INDEX user_id ON reset_password_token (user_id)');
        $this->addSql('DROP INDEX uniq_452c9ec55f37a13b ON reset_password_token');
        $this->addSql('CREATE UNIQUE INDEX token ON reset_password_token (token)');
        $this->addSql('ALTER TABLE reset_password_token ADD CONSTRAINT FK_452C9EC5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(150) NOT NULL, CHANGE roles roles TEXT DEFAULT NULL, CHANGE nom nom VARCHAR(100) DEFAULT NULL, CHANGE prenom prenom VARCHAR(100) DEFAULT NULL, CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE is_active is_active TINYINT DEFAULT 1, CHANGE is_verified is_verified TINYINT DEFAULT 0, CHANGE face_embedding face_embedding LONGTEXT DEFAULT NULL, CHANGE google_authenticator_secret google_authenticator_secret VARCHAR(255) DEFAULT NULL, CHANGE is_two_factor_enabled is_two_factor_enabled TINYINT DEFAULT 0');
        $this->addSql('CREATE INDEX idx_users_email ON `user` (email)');
        $this->addSql('CREATE INDEX idx_users_type ON `user` (type)');
        $this->addSql('DROP INDEX uniq_user_email ON `user`');
        $this->addSql('CREATE UNIQUE INDEX email ON `user` (email)');
    }
}
