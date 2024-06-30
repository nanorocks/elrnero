<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240630133815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init!';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_section_content_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE favorite_course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B79D86650F ON cart (user_id_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, parent_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C1B3750AF4 ON category (parent_id_id)');
        $this->addSql('CREATE TABLE category_course (id INT NOT NULL, category_id_id INT NOT NULL, course_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1976A5C29777D11E ON category_course (category_id_id)');
        $this->addSql('CREATE INDEX IDX_1976A5C296EF99BF ON category_course (course_id_id)');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, course_id_id INT NOT NULL, code VARCHAR(255) NOT NULL, is_valid BOOLEAN NOT NULL, absolute_discount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64BF3F0296EF99BF ON coupon (course_id_id)');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, user_id_id INT NOT NULL, cart_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, last_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, language VARCHAR(255) NOT NULL, total_hours INT DEFAULT NULL, total_videos INT DEFAULT NULL, total_articles INT DEFAULT NULL, downloadable_resources INT DEFAULT NULL, multi_platform_access BOOLEAN DEFAULT NULL, has_certificate BOOLEAN NOT NULL, price DOUBLE PRECISION NOT NULL, percentage_discount_for_price INT DEFAULT NULL, video_thumbnail VARCHAR(255) DEFAULT NULL, total_students INT NOT NULL, tags JSON DEFAULT NULL, level INT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_169E6FB99D86650F ON course (user_id_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB91AD5CDBF ON course (cart_id)');
        $this->addSql('CREATE TABLE course_playlist (id INT NOT NULL, course_id_id INT NOT NULL, playlist_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E367C7B96EF99BF ON course_playlist (course_id_id)');
        $this->addSql('CREATE INDEX IDX_7E367C7BDC588714 ON course_playlist (playlist_id_id)');
        $this->addSql('CREATE TABLE course_section (id INT NOT NULL, course_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_25B07F0396EF99BF ON course_section (course_id_id)');
        $this->addSql('CREATE TABLE course_section_content (id INT NOT NULL, course_section_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, duration VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, order_num INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC9C5F42B9EBDEA ON course_section_content (course_section_id_id)');
        $this->addSql('CREATE TABLE favorite_course (id INT NOT NULL, course_id_id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2A2B034396EF99BF ON favorite_course (course_id_id)');
        $this->addSql('CREATE INDEX IDX_2A2B03439D86650F ON favorite_course (user_id_id)');
        $this->addSql('CREATE TABLE feedback (id INT NOT NULL, user_id_id INT NOT NULL, course_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D22944589D86650F ON feedback (user_id_id)');
        $this->addSql('CREATE INDEX IDX_D229445896EF99BF ON feedback (course_id_id)');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_admin BOOLEAN NOT NULL, short_bio TEXT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, soc_media JSON DEFAULT NULL, is_business_user BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT FK_1976A5C29777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_course ADD CONSTRAINT FK_1976A5C296EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F0296EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB99D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB91AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT FK_7E367C7B96EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_playlist ADD CONSTRAINT FK_7E367C7BDC588714 FOREIGN KEY (playlist_id_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F0396EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_section_content ADD CONSTRAINT FK_DC9C5F42B9EBDEA FOREIGN KEY (course_section_id_id) REFERENCES course_section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B034396EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B03439D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944589D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445896EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_section_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_section_content_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE favorite_course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE feedback_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B79D86650F');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1B3750AF4');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT FK_1976A5C29777D11E');
        $this->addSql('ALTER TABLE category_course DROP CONSTRAINT FK_1976A5C296EF99BF');
        $this->addSql('ALTER TABLE coupon DROP CONSTRAINT FK_64BF3F0296EF99BF');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB99D86650F');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB91AD5CDBF');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT FK_7E367C7B96EF99BF');
        $this->addSql('ALTER TABLE course_playlist DROP CONSTRAINT FK_7E367C7BDC588714');
        $this->addSql('ALTER TABLE course_section DROP CONSTRAINT FK_25B07F0396EF99BF');
        $this->addSql('ALTER TABLE course_section_content DROP CONSTRAINT FK_DC9C5F42B9EBDEA');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B034396EF99BF');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B03439D86650F');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D22944589D86650F');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D229445896EF99BF');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_course');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_playlist');
        $this->addSql('DROP TABLE course_section');
        $this->addSql('DROP TABLE course_section_content');
        $this->addSql('DROP TABLE favorite_course');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}