<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331070538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transports DROP FOREIGN KEY FK_C7BE69E55258F8E6');
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, marque_car VARCHAR(255) NOT NULL, price_car DOUBLE PRECISION NOT NULL, address_car VARCHAR(255) NOT NULL, photo_car VARCHAR(255) NOT NULL, owner_tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uber (id INT AUTO_INCREMENT NOT NULL, nom_uber VARCHAR(255) NOT NULL, num_tel_uber INT NOT NULL, field_uber VARCHAR(255) NOT NULL, prix_uber DOUBLE PRECISION NOT NULL, photo_uber VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP INDEX IDX_C7BE69E55258F8E6 ON transports');
        $this->addSql('ALTER TABLE transports ADD car_id INT DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, ADD etat_transport VARCHAR(255) NOT NULL, DROP id_user, CHANGE id_vehicule_id uber_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transports ADD CONSTRAINT FK_C7BE69E56FE402AB FOREIGN KEY (uber_id) REFERENCES uber (id)');
        $this->addSql('ALTER TABLE transports ADD CONSTRAINT FK_C7BE69E5C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7BE69E56FE402AB ON transports (uber_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7BE69E5C3C6F69F ON transports (car_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transports DROP FOREIGN KEY FK_C7BE69E5C3C6F69F');
        $this->addSql('ALTER TABLE transports DROP FOREIGN KEY FK_C7BE69E56FE402AB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, nom_uber VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom_uber VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, marque_voiture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE uber');
        $this->addSql('DROP INDEX UNIQ_C7BE69E56FE402AB ON transports');
        $this->addSql('DROP INDEX UNIQ_C7BE69E5C3C6F69F ON transports');
        $this->addSql('ALTER TABLE transports ADD id_vehicule_id INT DEFAULT NULL, ADD id_user INT NOT NULL, DROP uber_id, DROP car_id, DROP type, DROP etat_transport');
        $this->addSql('ALTER TABLE transports ADD CONSTRAINT FK_C7BE69E55258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_C7BE69E55258F8E6 ON transports (id_vehicule_id)');
    }
}
