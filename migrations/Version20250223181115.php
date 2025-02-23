<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223181115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cat (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, breed VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, color VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cat.birth_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE cat_owners (owner INT NOT NULL, cat INT NOT NULL, PRIMARY KEY(owner, cat))');
        $this->addSql('CREATE INDEX IDX_9C75778FCF60E67C ON cat_owners (owner)');
        $this->addSql('CREATE INDEX IDX_9C75778F9E5E43A8 ON cat_owners (cat)');
        $this->addSql('ALTER TABLE cat_owners ADD CONSTRAINT FK_9C75778FCF60E67C FOREIGN KEY (owner) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cat_owners ADD CONSTRAINT FK_9C75778F9E5E43A8 FOREIGN KEY (cat) REFERENCES cat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cat_owners DROP CONSTRAINT FK_9C75778FCF60E67C');
        $this->addSql('ALTER TABLE cat_owners DROP CONSTRAINT FK_9C75778F9E5E43A8');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE cat_owners');
    }
}
