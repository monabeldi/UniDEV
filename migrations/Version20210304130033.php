<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304130033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel MODIFY id_hotel INT NOT NULL');
        $this->addSql('ALTER TABLE hotel DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE hotel CHANGE id_hotel idhotel INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD PRIMARY KEY (idhotel)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel MODIFY idhotel INT NOT NULL');
        $this->addSql('ALTER TABLE hotel DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE hotel CHANGE idhotel id_hotel INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD PRIMARY KEY (id_hotel)');
    }
}