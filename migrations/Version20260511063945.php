<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511063945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge_partenaire (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, nom VARCHAR(120) NOT NULL, description VARCHAR(255) NOT NULL, couleur VARCHAR(12) NOT NULL, icone VARCHAR(50) NOT NULL, score_impact INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_current TINYINT NOT NULL, partenaire_id INT NOT NULL, INDEX IDX_C5AC587198DE13AC (partenaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE bon_achat (id INT AUTO_INCREMENT NOT NULL, nom_magasin VARCHAR(255) NOT NULL, logo_magasin VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, valeur_monetaire DOUBLE PRECISION NOT NULL, points_requis INT NOT NULL, date_debut DATE NOT NULL, date_expiration DATE NOT NULL, nombre_maximum_utilisations INT NOT NULL, nombre_utilisations INT NOT NULL, conditions_utilisation LONGTEXT DEFAULT NULL, zone_geographique VARCHAR(255) DEFAULT NULL, image_promotionnelle VARCHAR(255) DEFAULT NULL, statut VARCHAR(32) NOT NULL, historique_modifications JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, partenaire_id INT NOT NULL, INDEX IDX_5B8DF14A98DE13AC (partenaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE declaration_dechet (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, quantite DOUBLE PRECISION NOT NULL, unite VARCHAR(255) NOT NULL, created_at DATE NOT NULL, score_ia DOUBLE PRECISION DEFAULT NULL, points_attribues INT NOT NULL, qr_code VARCHAR(255) DEFAULT NULL, date_confirmation DATETIME DEFAULT NULL, statut_historique JSON DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, type_dechet_id INT NOT NULL, citoyen_id INT DEFAULT NULL, valorisateur_confirmateur_id INT DEFAULT NULL, INDEX IDX_71D10FB6B93D2352 (type_dechet_id), INDEX IDX_71D10FB643787BBA (citoyen_id), INDEX IDX_71D10FB650CF28C2 (valorisateur_confirmateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_dechet (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, valeur_points_kg DOUBLE PRECISION NOT NULL, description_tri VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE wallet (id_wallet INT AUTO_INCREMENT NOT NULL, solde_actuel INT NOT NULL, date_mj DATETIME NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_7C68921FFB88E14F (utilisateur_id), PRIMARY KEY (id_wallet)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE wallet_transaction (id_transaction INT AUTO_INCREMENT NOT NULL, montant INT NOT NULL, type VARCHAR(50) NOT NULL, motif VARCHAR(255) NOT NULL, date_transaction DATETIME NOT NULL, wallet_id INT NOT NULL, INDEX IDX_7DAF972712520F3 (wallet_id), PRIMARY KEY (id_transaction)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE badge_partenaire ADD CONSTRAINT FK_C5AC587198DE13AC FOREIGN KEY (partenaire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bon_achat ADD CONSTRAINT FK_5B8DF14A98DE13AC FOREIGN KEY (partenaire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_71D10FB6B93D2352 FOREIGN KEY (type_dechet_id) REFERENCES type_dechet (id)');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_71D10FB643787BBA FOREIGN KEY (citoyen_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE declaration_dechet ADD CONSTRAINT FK_71D10FB650CF28C2 FOREIGN KEY (valorisateur_confirmateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wallet_transaction ADD CONSTRAINT FK_7DAF972712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id_wallet)');
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
        $this->addSql('ALTER TABLE badge_partenaire DROP FOREIGN KEY FK_C5AC587198DE13AC');
        $this->addSql('ALTER TABLE bon_achat DROP FOREIGN KEY FK_5B8DF14A98DE13AC');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY FK_71D10FB6B93D2352');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY FK_71D10FB643787BBA');
        $this->addSql('ALTER TABLE declaration_dechet DROP FOREIGN KEY FK_71D10FB650CF28C2');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921FFB88E14F');
        $this->addSql('ALTER TABLE wallet_transaction DROP FOREIGN KEY FK_7DAF972712520F3');
        $this->addSql('DROP TABLE badge_partenaire');
        $this->addSql('DROP TABLE bon_achat');
        $this->addSql('DROP TABLE declaration_dechet');
        $this->addSql('DROP TABLE type_dechet');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE wallet_transaction');
        $this->addSql('ALTER TABLE appel_offre DROP FOREIGN KEY FK_BC56FD475BE119DC');
        $this->addSql('DROP INDEX IDX_BC56FD475BE119DC ON appel_offre');
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
