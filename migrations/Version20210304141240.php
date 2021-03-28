<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304141240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel CHANGE idhotel idhotel INT AUTO_INCREMENT NOT NULL, CHANGE photo_hotel photohotel VARCHAR(255) NOT NULL, ADD PRIMARY KEY (idhotel)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel MODIFY idhotel INT NOT NULL');
        $this->addSql('ALTER TABLE hotel DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE hotel CHANGE idhotel idhotel INT NOT NULL, CHANGE photohotel photo_hotel VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
