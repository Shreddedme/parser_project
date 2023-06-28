<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627115515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE data_update_dates (id INT AUTO_INCREMENT NOT NULL, last_update DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE debt (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, tax_id INT DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DBBF0A839E6B1585 (organisation_id), INDEX IDX_DBBF0A83B2A824D8 (tax_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, inn INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8E81BA769E6B1585 (organisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE debt ADD CONSTRAINT FK_DBBF0A839E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE debt ADD CONSTRAINT FK_DBBF0A83B2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id)');
        $this->addSql('ALTER TABLE tax ADD CONSTRAINT FK_8E81BA769E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debt DROP FOREIGN KEY FK_DBBF0A839E6B1585');
        $this->addSql('ALTER TABLE debt DROP FOREIGN KEY FK_DBBF0A83B2A824D8');
        $this->addSql('ALTER TABLE tax DROP FOREIGN KEY FK_8E81BA769E6B1585');
        $this->addSql('DROP TABLE data_update_dates');
        $this->addSql('DROP TABLE debt');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
