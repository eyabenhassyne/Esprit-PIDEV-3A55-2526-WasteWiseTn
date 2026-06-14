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
        return 'Migration dupliquee conservee pour la chronologie: operation desactivee';
    }

    public function up(Schema $schema): void
    {
        // Cette migration etait un snapshot duplique des migrations precedentes.
        // Elle est desactivee pour eviter une erreur "table already exists" sur un setup propre.
    }

    public function down(Schema $schema): void
    {
        // No-op: la migration ne modifie plus le schema.
    }
}
