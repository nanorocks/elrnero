<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240630142704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add orders, rename relations between tables!';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, user_id INT NOT NULL, course_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, paymet_status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('CREATE INDEX IDX_F5299398591CC992 ON "order" (course_id)');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BA388B7591CC992 ON cart (course_id)');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT fk_169e6fb99d86650f');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT fk_169e6fb91ad5cdbf');
        $this->addSql('DROP INDEX idx_169e6fb91ad5cdbf');
        $this->addSql('DROP INDEX idx_169e6fb99d86650f');
        $this->addSql('ALTER TABLE course DROP cart_id');
        $this->addSql('ALTER TABLE course RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_169E6FB9A76ED395 ON course (user_id)');
        $this->addSql('ALTER TABLE course_section ADD order_num INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398591CC992');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB9A76ED395');
        $this->addSql('DROP INDEX IDX_169E6FB9A76ED395');
        $this->addSql('ALTER TABLE course ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT fk_169e6fb99d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT fk_169e6fb91ad5cdbf FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_169e6fb91ad5cdbf ON course (cart_id)');
        $this->addSql('CREATE INDEX idx_169e6fb99d86650f ON course (user_id_id)');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7591CC992');
        $this->addSql('DROP INDEX IDX_BA388B7591CC992');
        $this->addSql('ALTER TABLE cart DROP course_id');
        $this->addSql('ALTER TABLE course_section DROP order_num');
    }
}