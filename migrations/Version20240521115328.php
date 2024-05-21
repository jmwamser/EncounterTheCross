<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521115328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD address_locale VARCHAR(255) NOT NULL, ADD address_given_name VARCHAR(255) NOT NULL, ADD address_additional_name VARCHAR(255) NOT NULL, ADD address_family_name VARCHAR(255) NOT NULL, ADD address_organization VARCHAR(255) NOT NULL, ADD address_address_line1 VARCHAR(255) NOT NULL, ADD address_address_line2 VARCHAR(255) NOT NULL, ADD address_address_line3 VARCHAR(255) NOT NULL, ADD address_postal_code VARCHAR(255) NOT NULL, ADD address_sorting_code VARCHAR(255) NOT NULL, ADD address_locality VARCHAR(255) NOT NULL, ADD address_dependent_locality VARCHAR(255) NOT NULL, ADD address_administrative_area VARCHAR(255) NOT NULL, ADD address_country_code VARCHAR(2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP address_locale, DROP address_given_name, DROP address_additional_name, DROP address_family_name, DROP address_organization, DROP address_address_line1, DROP address_address_line2, DROP address_address_line3, DROP address_postal_code, DROP address_sorting_code, DROP address_locality, DROP address_dependent_locality, DROP address_administrative_area, DROP address_country_code');
    }
}
