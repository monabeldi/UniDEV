<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322154938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boutique CHANGE nom_boutique nom_boutique VARCHAR(255) NOT NULL, CHANGE address_boutiques address_boutiques VARCHAR(255) NOT NULL, CHANGE num_tel_boutique num_tel_boutique INT NOT NULL, CHANGE email_boutique email_boutique VARCHAR(255) NOT NULL, CHANGE photo_boutique photo_boutique VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD boutique_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27AB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27AB677BE6 ON produit (boutique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boutique CHANGE nom_boutique nom_boutique VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address_boutiques address_boutiques VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_tel_boutique num_tel_boutique INT DEFAULT NULL, CHANGE email_boutique email_boutique VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo_boutique photo_boutique VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27AB677BE6');
        $this->addSql('DROP INDEX IDX_29A5EC27AB677BE6 ON produit');
        $this->addSql('ALTER TABLE produit DROP boutique_id');
    }
}
