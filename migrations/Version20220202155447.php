<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202155447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acces (id INT AUTO_INCREMENT NOT NULL, utilisateurd_id_id INT NOT NULL, document_id_id INT NOT NULL, autorisation_id_id INT NOT NULL, INDEX IDX_D0F43B103EB5B9E8 (utilisateurd_id_id), INDEX IDX_D0F43B1016E5E825 (document_id_id), INDEX IDX_D0F43B103B0E139B (autorisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation (id INT AUTO_INCREMENT NOT NULL, lecture TINYINT(1) NOT NULL, ecriture TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, chemin VARCHAR(255) NOT NULL, date DATETIME NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B103EB5B9E8 FOREIGN KEY (utilisateurd_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B1016E5E825 FOREIGN KEY (document_id_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B103B0E139B FOREIGN KEY (autorisation_id_id) REFERENCES autorisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B103B0E139B');
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B1016E5E825');
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B103EB5B9E8');
        $this->addSql('DROP TABLE acces');
        $this->addSql('DROP TABLE autorisation');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE utilisateur');
    }
}
