<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909124127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etage (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport ADD etage_id INT NOT NULL, ADD localisation_id INT NOT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C984CE93F FOREIGN KEY (etage_id) REFERENCES etage (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C984CE93F ON rapport (etage_id)');
        $this->addSql('CREATE INDEX IDX_BE34A09CC68BE09C ON rapport (localisation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C984CE93F');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CC68BE09C');
        $this->addSql('DROP TABLE etage');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP INDEX IDX_BE34A09C984CE93F ON rapport');
        $this->addSql('DROP INDEX IDX_BE34A09CC68BE09C ON rapport');
        $this->addSql('ALTER TABLE rapport DROP etage_id, DROP localisation_id');
    }
}
