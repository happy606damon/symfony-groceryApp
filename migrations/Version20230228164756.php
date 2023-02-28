<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228164756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1F1B251E19EB6921 ON item (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E19EB6921');
        $this->addSql('DROP INDEX IDX_1F1B251E19EB6921');
        $this->addSql('ALTER TABLE item DROP client_id');
    }
}
