<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627122207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_caracteristique (type_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_267B2AFFC54C8C93 (type_id), INDEX IDX_267B2AFF1704EEB7 (caracteristique_id), PRIMARY KEY(type_id, caracteristique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_caracteristique ADD CONSTRAINT FK_267B2AFFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_caracteristique ADD CONSTRAINT FK_267B2AFF1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complement ADD CONSTRAINT FK_F8A41E34C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_F8A41E34C54C8C93 ON complement (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type_caracteristique');
        $this->addSql('ALTER TABLE complement DROP FOREIGN KEY FK_F8A41E34C54C8C93');
        $this->addSql('DROP INDEX IDX_F8A41E34C54C8C93 ON complement');
        $this->addSql('ALTER TABLE complement DROP type_id');
    }
}
