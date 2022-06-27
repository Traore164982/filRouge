<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627120831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD produit_id_id INT DEFAULT NULL, ADD complement_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A934FD8F9C3 FOREIGN KEY (produit_id_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93CC99B2A9 FOREIGN KEY (complement_id_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_7D053A934FD8F9C3 ON menu (produit_id_id)');
        $this->addSql('CREATE INDEX IDX_7D053A93CC99B2A9 ON menu (complement_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A934FD8F9C3');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93CC99B2A9');
        $this->addSql('DROP INDEX IDX_7D053A934FD8F9C3 ON menu');
        $this->addSql('DROP INDEX IDX_7D053A93CC99B2A9 ON menu');
        $this->addSql('ALTER TABLE menu DROP produit_id_id, DROP complement_id_id');
    }
}
