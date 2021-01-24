<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124210613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD membre_id INT NOT NULL, ADD menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6A99F74A ON commande (membre_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DCCD7E912 ON commande (menu_id)');
        $this->addSql('ALTER TABLE menu ADD membre_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_7D053A936A99F74A ON menu (membre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6A99F74A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DCCD7E912');
        $this->addSql('DROP INDEX IDX_6EEAA67D6A99F74A ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DCCD7E912 ON commande');
        $this->addSql('ALTER TABLE commande DROP membre_id, DROP menu_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936A99F74A');
        $this->addSql('DROP INDEX IDX_7D053A936A99F74A ON menu');
        $this->addSql('ALTER TABLE menu DROP membre_id');
    }
}
