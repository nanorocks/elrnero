<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240630140718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Clean up on tables and renames over relations!';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT fk_ba388b79d86650f');
        $this->addSql('DROP INDEX uniq_ba388b79d86650f');
        $this->addSql('ALTER TABLE cart RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT fk_64c19c1b3750af4');
        $this->addSql('DROP INDEX idx_64c19c1b3750af4');
        $this->addSql('ALTER TABLE category RENAME COLUMN parent_id_id TO parent_id');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT fk_1976a5c29777d11e');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT fk_1976a5c296ef99bf');
        $this->addSql('DROP INDEX idx_1976a5c296ef99bf');
        $this->addSql('DROP INDEX idx_1976a5c29777d11e');
        $this->addSql('ALTER TABLE category_course ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_course ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_course DROP category_id_id');
        $this->addSql('ALTER TABLE category_course DROP course_id_id');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT FK_1976A5C212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT FK_1976A5C2591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1976A5C212469DE2 ON category_course (category_id)');
        $this->addSql('CREATE INDEX IDX_1976A5C2591CC992 ON category_course (course_id)');
        $this->addSql('ALTER TABLE coupon DROP CONSTRAINT fk_64bf3f0296ef99bf');
        $this->addSql('DROP INDEX idx_64bf3f0296ef99bf');
        $this->addSql('ALTER TABLE coupon RENAME COLUMN course_id_id TO course_id');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F02591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64BF3F02591CC992 ON coupon (course_id)');
        $this->addSql('ALTER TABLE course RENAME COLUMN title TO name');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT fk_7e367c7b96ef99bf');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT fk_7e367c7bdc588714');
        $this->addSql('DROP INDEX idx_7e367c7bdc588714');
        $this->addSql('DROP INDEX idx_7e367c7b96ef99bf');
        $this->addSql('ALTER TABLE course_playlist ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE course_playlist ADD playlist_id INT NOT NULL');
        $this->addSql('ALTER TABLE course_playlist DROP course_id_id');
        $this->addSql('ALTER TABLE course_playlist DROP playlist_id_id');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT FK_7E367C7B591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT FK_7E367C7B6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7E367C7B591CC992 ON course_playlist (course_id)');
        $this->addSql('CREATE INDEX IDX_7E367C7B6BBD148 ON course_playlist (playlist_id)');
        $this->addSql('ALTER TABLE course_section DROP CONSTRAINT fk_25b07f0396ef99bf');
        $this->addSql('DROP INDEX idx_25b07f0396ef99bf');
        $this->addSql('ALTER TABLE course_section RENAME COLUMN course_id_id TO course_id');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F03591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_25B07F03591CC992 ON course_section (course_id)');
        $this->addSql('ALTER TABLE course_section_content DROP CONSTRAINT fk_dc9c5f42b9ebdea');
        $this->addSql('DROP INDEX idx_dc9c5f42b9ebdea');
        $this->addSql('ALTER TABLE course_section_content RENAME COLUMN course_section_id_id TO course_section_id');
        $this->addSql('ALTER TABLE course_section_content ADD CONSTRAINT FK_DC9C5F47C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DC9C5F47C1ADF9 ON course_section_content (course_section_id)');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT fk_2a2b034396ef99bf');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT fk_2a2b03439d86650f');
        $this->addSql('DROP INDEX idx_2a2b03439d86650f');
        $this->addSql('DROP INDEX idx_2a2b034396ef99bf');
        $this->addSql('ALTER TABLE favorite_course ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_course ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_course DROP course_id_id');
        $this->addSql('ALTER TABLE favorite_course DROP user_id_id');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2A2B0343591CC992 ON favorite_course (course_id)');
        $this->addSql('CREATE INDEX IDX_2A2B0343A76ED395 ON favorite_course (user_id)');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT fk_d22944589d86650f');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT fk_d229445896ef99bf');
        $this->addSql('DROP INDEX idx_d229445896ef99bf');
        $this->addSql('DROP INDEX idx_d22944589d86650f');
        $this->addSql('ALTER TABLE feedback RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE feedback RENAME COLUMN course_id_id TO course_id');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D2294458A76ED395 ON feedback (user_id)');
        $this->addSql('CREATE INDEX IDX_D2294458591CC992 ON feedback (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7A76ED395');
        $this->addSql('DROP INDEX UNIQ_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT fk_ba388b79d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_ba388b79d86650f ON cart (user_id_id)');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1727ACA70');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('ALTER TABLE category RENAME COLUMN parent_id TO parent_id_id');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT fk_64c19c1b3750af4 FOREIGN KEY (parent_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_64c19c1b3750af4 ON category (parent_id_id)');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT FK_1976A5C212469DE2');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT FK_1976A5C2591CC992');
        $this->addSql('DROP INDEX IDX_1976A5C212469DE2');
        $this->addSql('DROP INDEX IDX_1976A5C2591CC992');
        $this->addSql('ALTER TABLE category_course ADD category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_course ADD course_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_course DROP category_id');
        $this->addSql('ALTER TABLE category_course DROP course_id');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT fk_1976a5c29777d11e FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT fk_1976a5c296ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1976a5c296ef99bf ON category_course (course_id_id)');
        $this->addSql('CREATE INDEX idx_1976a5c29777d11e ON category_course (category_id_id)');
        $this->addSql('ALTER TABLE course RENAME COLUMN name TO title');
        $this->addSql('ALTER TABLE coupon DROP CONSTRAINT FK_64BF3F02591CC992');
        $this->addSql('DROP INDEX IDX_64BF3F02591CC992');
        $this->addSql('ALTER TABLE coupon RENAME COLUMN course_id TO course_id_id');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT fk_64bf3f0296ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_64bf3f0296ef99bf ON coupon (course_id_id)');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT FK_7E367C7B591CC992');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT FK_7E367C7B6BBD148');
        $this->addSql('DROP INDEX IDX_7E367C7B591CC992');
        $this->addSql('DROP INDEX IDX_7E367C7B6BBD148');
        $this->addSql('ALTER TABLE course_playlist ADD course_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE course_playlist ADD playlist_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE course_playlist DROP course_id');
        $this->addSql('ALTER TABLE course_playlist DROP playlist_id');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT fk_7e367c7b96ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT fk_7e367c7bdc588714 FOREIGN KEY (playlist_id_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7e367c7bdc588714 ON course_playlist (playlist_id_id)');
        $this->addSql('CREATE INDEX idx_7e367c7b96ef99bf ON course_playlist (course_id_id)');
        $this->addSql('ALTER TABLE course_section DROP CONSTRAINT FK_25B07F03591CC992');
        $this->addSql('DROP INDEX IDX_25B07F03591CC992');
        $this->addSql('ALTER TABLE course_section RENAME COLUMN course_id TO course_id_id');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT fk_25b07f0396ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_25b07f0396ef99bf ON course_section (course_id_id)');
        $this->addSql('ALTER TABLE course_section_content DROP CONSTRAINT FK_DC9C5F47C1ADF9');
        $this->addSql('DROP INDEX IDX_DC9C5F47C1ADF9');
        $this->addSql('ALTER TABLE course_section_content RENAME COLUMN course_section_id TO course_section_id_id');
        $this->addSql('ALTER TABLE course_section_content ADD CONSTRAINT fk_dc9c5f42b9ebdea FOREIGN KEY (course_section_id_id) REFERENCES course_section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_dc9c5f42b9ebdea ON course_section_content (course_section_id_id)');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B0343591CC992');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B0343A76ED395');
        $this->addSql('DROP INDEX IDX_2A2B0343591CC992');
        $this->addSql('DROP INDEX IDX_2A2B0343A76ED395');
        $this->addSql('ALTER TABLE favorite_course ADD course_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_course ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_course DROP course_id');
        $this->addSql('ALTER TABLE favorite_course DROP user_id');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT fk_2a2b034396ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT fk_2a2b03439d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2a2b03439d86650f ON favorite_course (user_id_id)');
        $this->addSql('CREATE INDEX idx_2a2b034396ef99bf ON favorite_course (course_id_id)');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458A76ED395');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458591CC992');
        $this->addSql('DROP INDEX IDX_D2294458A76ED395');
        $this->addSql('DROP INDEX IDX_D2294458591CC992');
        $this->addSql('ALTER TABLE feedback RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE feedback RENAME COLUMN course_id TO course_id_id');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT fk_d22944589d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT fk_d229445896ef99bf FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d229445896ef99bf ON feedback (course_id_id)');
        $this->addSql('CREATE INDEX idx_d22944589d86650f ON feedback (user_id_id)');
    }
}