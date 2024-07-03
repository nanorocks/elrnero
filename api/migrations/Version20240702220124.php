<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702220124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE course ADD is_published BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398591cc992');
        $this->addSql('DROP INDEX idx_f5299398591cc992');
        $this->addSql('ALTER TABLE "order" ADD cart_to_order JSON NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP course_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE course DROP is_published');
        $this->addSql('ALTER TABLE "order" ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP cart_to_order');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f5299398591cc992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f5299398591cc992 ON "order" (course_id)');
        $this->addSql('ALTER TABLE category DROP slug');
    }
}
