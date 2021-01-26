<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126162430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, menu_id INT NOT NULL, date_commande DATE NOT NULL, INDEX IDX_6EEAA67D6A99F74A (membre_id), INDEX IDX_6EEAA67DCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, mail VARCHAR(255) NOT NULL, ville VARCHAR(100) NOT NULL, cp VARCHAR(5) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(10) NOT NULL, siret VARCHAR(14) DEFAULT NULL, tva VARCHAR(13) DEFAULT NULL, descriptif LONGTEXT DEFAULT NULL, langue VARCHAR(100) DEFAULT NULL, zone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F6B4FB2986CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, nom VARCHAR(50) NOT NULL, specialite VARCHAR(30) NOT NULL, entree VARCHAR(30) DEFAULT NULL, plat VARCHAR(30) NOT NULL, dessert VARCHAR(30) DEFAULT NULL, prix VARCHAR(10) NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_7D053A936A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6A99F74A');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936A99F74A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DCCD7E912');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE menu');
    }
}
