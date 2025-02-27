<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225104740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cat (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, breed VARCHAR(255) DEFAULT NULL, weight VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E5E43A85E237E06 ON cat (name)');
        $this->addSql('COMMENT ON COLUMN cat.birth_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE task (id SERIAL NOT NULL, user_id INT DEFAULT NULL, care_type VARCHAR(255) NOT NULL, comment TEXT DEFAULT NULL, done BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE TABLE cat_owners (owner INT NOT NULL, cat INT NOT NULL, PRIMARY KEY(owner, cat))');
        $this->addSql('CREATE INDEX IDX_9C75778FCF60E67C ON cat_owners (owner)');
        $this->addSql('CREATE INDEX IDX_9C75778F9E5E43A8 ON cat_owners (cat)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cat_owners ADD CONSTRAINT FK_9C75778FCF60E67C FOREIGN KEY (owner) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cat_owners ADD CONSTRAINT FK_9C75778F9E5E43A8 FOREIGN KEY (cat) REFERENCES cat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE cat_owners DROP CONSTRAINT FK_9C75778FCF60E67C');
        $this->addSql('ALTER TABLE cat_owners DROP CONSTRAINT FK_9C75778F9E5E43A8');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE cat_owners');
    }
}
