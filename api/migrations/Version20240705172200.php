<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705172200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D782112D9D86650F ON playlist (user_id_id)');
        $this->addSql('ALTER TABLE "user" ALTER roles DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE playlist DROP CONSTRAINT FK_D782112D9D86650F');
        $this->addSql('DROP INDEX IDX_D782112D9D86650F');
        $this->addSql('ALTER TABLE playlist DROP user_id_id');
        $this->addSql('ALTER TABLE "user" ALTER roles SET DEFAULT \'["ROLE_USER"]\'');
    }
}
