<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226052606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_person (id INT UNSIGNED AUTO_INCREMENT NOT NULL, details_id INT UNSIGNED NOT NULL, relationship VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_A44EE6F75A89FD83 (row_pointer), INDEX IDX_A44EE6F7BB1A0722 (details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT UNSIGNED AUTO_INCREMENT NOT NULL, location_id INT UNSIGNED NOT NULL, start DATE NOT NULL, end DATE NOT NULL, registration_dead_line_servers DATE NOT NULL, name VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_3BAE0AA75A89FD83 (row_pointer), INDEX IDX_3BAE0AA764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_location (event_id INT UNSIGNED NOT NULL, location_id INT UNSIGNED NOT NULL, INDEX IDX_1872601B71F7E88B (event_id), INDEX IDX_1872601B64D218E (location_id), PRIMARY KEY(event_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_attendee (id INT UNSIGNED AUTO_INCREMENT NOT NULL, launch_point_id INT UNSIGNED NOT NULL, church VARCHAR(255) DEFAULT NULL, invited_by VARCHAR(255) DEFAULT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', questions_or_comments LONGTEXT DEFAULT NULL, concerns LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_57BC3CB75A89FD83 (row_pointer), INDEX IDX_57BC3CB7A495DAEF (launch_point_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_server (id INT UNSIGNED AUTO_INCREMENT NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', questions_or_comments LONGTEXT DEFAULT NULL, concerns LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_68F4A2A45A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', line1 VARCHAR(255) NOT NULL, line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CB5A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT UNSIGNED AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, row_pointer BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_34DCD1765A89FD83 (row_pointer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7BB1A0722 FOREIGN KEY (details_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_attendee ADD CONSTRAINT FK_57BC3CB7A495DAEF FOREIGN KEY (launch_point_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_person DROP FOREIGN KEY FK_A44EE6F7BB1A0722');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE event_location DROP FOREIGN KEY FK_1872601B71F7E88B');
        $this->addSql('ALTER TABLE event_location DROP FOREIGN KEY FK_1872601B64D218E');
        $this->addSql('ALTER TABLE event_attendee DROP FOREIGN KEY FK_57BC3CB7A495DAEF');
        $this->addSql('DROP TABLE contact_person');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_location');
        $this->addSql('DROP TABLE event_attendee');
        $this->addSql('DROP TABLE event_server');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE person');
    }
}
