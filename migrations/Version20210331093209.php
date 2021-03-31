<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331093209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre ADD hotel_id INT DEFAULT NULL, ADD id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_C509E4FF3243BB18 ON chambre (hotel_id)');
        $this->addSql('ALTER TABLE hotel ADD id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF3243BB18');
        $this->addSql('DROP INDEX IDX_C509E4FF3243BB18 ON chambre');
        $this->addSql('ALTER TABLE chambre DROP hotel_id, DROP id');
        $this->addSql('ALTER TABLE hotel DROP id');
    }
}
