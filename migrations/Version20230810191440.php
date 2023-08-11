<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810191440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leader ADD launch_point_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT FK_F5E3EAD7A495DAEF FOREIGN KEY (launch_point_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_F5E3EAD7A495DAEF ON leader (launch_point_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY FK_F5E3EAD7A495DAEF');
        $this->addSql('DROP INDEX IDX_F5E3EAD7A495DAEF ON leader');
        $this->addSql('ALTER TABLE leader DROP launch_point_id');
    }
}
