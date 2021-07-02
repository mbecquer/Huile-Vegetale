<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702141711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_article (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD pictures_id INT DEFAULT NULL, DROP image, DROP filename');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BC415685 FOREIGN KEY (pictures_id) REFERENCES picture_article (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66BC415685 ON article (pictures_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BC415685');
        $this->addSql('DROP TABLE picture_article');
        $this->addSql('DROP INDEX UNIQ_23A0E66BC415685 ON article');
        $this->addSql('ALTER TABLE article ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP pictures_id');
    }
}
