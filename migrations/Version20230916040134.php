<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916040134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_person (id INT UNSIGNED AUTO_INCREMENT NOT NULL, details_id INT UNSIGNED NOT NULL, relationship VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A44EE6F75A89FD83 (row_pointer), INDEX IDX_A44EE6F7BB1A0722 (details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT UNSIGNED AUTO_INCREMENT NOT NULL, location_id INT UNSIGNED NOT NULL, start DATE NOT NULL, end DATE NOT NULL, registration_dead_line_servers DATE NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(20, 8) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3BAE0AA75A89FD83 (row_pointer), INDEX IDX_3BAE0AA764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_location (event_id INT UNSIGNED NOT NULL, location_id INT UNSIGNED NOT NULL, INDEX IDX_1872601B71F7E88B (event_id), INDEX IDX_1872601B64D218E (location_id), PRIMARY KEY(event_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_participant (id INT UNSIGNED AUTO_INCREMENT NOT NULL, launch_point_id INT UNSIGNED NOT NULL, person_id INT UNSIGNED NOT NULL, attendee_contact_person_id INT UNSIGNED DEFAULT NULL, event_id INT UNSIGNED NOT NULL, church VARCHAR(255) DEFAULT NULL, invited_by VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, server_attended_times INT DEFAULT NULL, paid TINYINT(1) NOT NULL, payment_method VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, line1 VARCHAR(255) NOT NULL, line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, questions_or_comments LONGTEXT DEFAULT NULL, health_concerns LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_7C16B8915A89FD83 (row_pointer), INDEX IDX_7C16B891A495DAEF (launch_point_id), INDEX IDX_7C16B891217BBB47 (person_id), INDEX IDX_7C16B891B43FBBC6 (attendee_contact_person_id), INDEX IDX_7C16B89171F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader (id INT UNSIGNED AUTO_INCREMENT NOT NULL, person_id INT UNSIGNED NOT NULL, launch_point_id INT UNSIGNED DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F5E3EAD7E7927C74 (email), UNIQUE INDEX UNIQ_F5E3EAD75A89FD83 (row_pointer), UNIQUE INDEX UNIQ_F5E3EAD7217BBB47 (person_id), INDEX IDX_F5E3EAD7A495DAEF (launch_point_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, geolocation JSON DEFAULT NULL, pin_color VARCHAR(255) DEFAULT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, line1 VARCHAR(255) NOT NULL, line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CB5A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT UNSIGNED AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_34DCD1765A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7CE748A5A89FD83 (row_pointer), INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonial (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quote LONGTEXT NOT NULL, city VARCHAR(255) NOT NULL, sharable TINYINT(1) NOT NULL, attended_at VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, approved TINYINT(1) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E6BDCDF75A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7BB1A0722 FOREIGN KEY (details_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B891A495DAEF FOREIGN KEY (launch_point_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B891217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B891B43FBBC6 FOREIGN KEY (attendee_contact_person_id) REFERENCES contact_person (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B89171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT FK_F5E3EAD7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT FK_F5E3EAD7A495DAEF FOREIGN KEY (launch_point_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES leader (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_person DROP FOREIGN KEY FK_A44EE6F7BB1A0722');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE event_location DROP FOREIGN KEY FK_1872601B71F7E88B');
        $this->addSql('ALTER TABLE event_location DROP FOREIGN KEY FK_1872601B64D218E');
        $this->addSql('ALTER TABLE event_participant DROP FOREIGN KEY FK_7C16B891A495DAEF');
        $this->addSql('ALTER TABLE event_participant DROP FOREIGN KEY FK_7C16B891217BBB47');
        $this->addSql('ALTER TABLE event_participant DROP FOREIGN KEY FK_7C16B891B43FBBC6');
        $this->addSql('ALTER TABLE event_participant DROP FOREIGN KEY FK_7C16B89171F7E88B');
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY FK_F5E3EAD7217BBB47');
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY FK_F5E3EAD7A495DAEF');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE contact_person');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_location');
        $this->addSql('DROP TABLE event_participant');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE testimonial');
    }
}
