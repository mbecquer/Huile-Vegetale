<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011145558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE huiles CHANGE family_id family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE huiles ADD CONSTRAINT FK_B2327682C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_B2327682C35E566A ON huiles (family_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE huiles DROP FOREIGN KEY FK_B2327682C35E566A');
        $this->addSql('DROP INDEX IDX_B2327682C35E566A ON huiles');
        $this->addSql('ALTER TABLE huiles CHANGE family_id family_id INT NOT NULL');
    }
}
