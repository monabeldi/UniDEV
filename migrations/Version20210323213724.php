<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210323213724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants ADD catalogue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurants ADD CONSTRAINT FK_CATALOGUE_RESTAURANT FOREIGN KEY (catalogue_id) REFERENCES catalogues (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CATALOGUE_RESTAURANT ON restaurants (catalogue_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants DROP FOREIGN KEY FK_CATALOGUE_RESTAURANT');
        $this->addSql('DROP INDEX UNIQ_CATALOGUE_RESTAURANT ON restaurants');
        $this->addSql('ALTER TABLE restaurants DROP catalogue_id INT DEFAULT NULL');
    }
}
