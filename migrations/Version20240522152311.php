<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522152311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD server_location_name VARCHAR(255) DEFAULT NULL, ADD server_location_address VARCHAR(255) DEFAULT NULL, ADD server_location_city VARCHAR(255) DEFAULT NULL, ADD server_location_state VARCHAR(255) DEFAULT NULL, ADD server_location_zip VARCHAR(255) DEFAULT NULL, ADD server_start_time DATETIME DEFAULT NULL, ADD server_timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('UPDATE event set server_timezone = \'America/Chicago\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP server_location_name, DROP server_location_address, DROP server_location_city, DROP server_location_state, DROP server_location_zip, DROP server_start_time, DROP server_timezone');
    }
}
