<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223184112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat ALTER breed DROP NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER weight DROP NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER birth_date DROP NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER color DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat ALTER breed SET NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER weight SET NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER birth_date SET NOT NULL');
        $this->addSql('ALTER TABLE cat ALTER color SET NOT NULL');
    }
}
