<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303115706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username_admin VARCHAR(255) NOT NULL, password_admin VARCHAR(32) NOT NULL, email_admin VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76B5473CA (username_admin), UNIQUE INDEX UNIQ_880E0D7615434CF9 (email_admin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_client VARCHAR(255) NOT NULL, prenom_client VARCHAR(255) NOT NULL, national_client VARCHAR(255) NOT NULL, email_client VARCHAR(255) NOT NULL, password_client VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_C7440455478B9B02 (nom_client), UNIQUE INDEX UNIQ_C7440455BADED7A5 (email_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guides (id INT AUTO_INCREMENT NOT NULL, nom_gui VARCHAR(255) NOT NULL, prenom_gui VARCHAR(255) NOT NULL, laungues_gui LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', etat_gui VARCHAR(255) NOT NULL, secteur_gui LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', avis_gui LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', desc_gui VARCHAR(255) NOT NULL, num_tel_gui INT NOT NULL, photo_gui VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transports (id INT AUTO_INCREMENT NOT NULL, type_trans VARCHAR(255) NOT NULL, date_debut_trans DATE NOT NULL, date_fin_trans DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uber (id INT AUTO_INCREMENT NOT NULL, nom_uber VARCHAR(255) NOT NULL, prenom_uber VARCHAR(255) NOT NULL, desc_uber VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voitures (id INT AUTO_INCREMENT NOT NULL, maruque_voiture VARCHAR(255) NOT NULL, desc_voiture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE guides');
        $this->addSql('DROP TABLE transports');
        $this->addSql('DROP TABLE uber');
        $this->addSql('DROP TABLE voitures');
    }
}
