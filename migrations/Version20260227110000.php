<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260227110000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout stripe_connect_account_id sur user pour les retraits Stripe';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `user` ADD stripe_connect_account_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `user` DROP stripe_connect_account_id');
    }
}

