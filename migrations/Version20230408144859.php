<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408144859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leader ADD person_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT FK_F5E3EAD7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5E3EAD7217BBB47 ON leader (person_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY FK_F5E3EAD7217BBB47');
        $this->addSql('DROP INDEX UNIQ_F5E3EAD7217BBB47 ON leader');
        $this->addSql('ALTER TABLE leader DROP person_id');
    }
}
