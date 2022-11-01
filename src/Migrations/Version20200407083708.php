<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407083708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, presentez_vous VARCHAR(255) DEFAULT NULL, musique VARCHAR(255) DEFAULT NULL, fumeur VARCHAR(255) DEFAULT NULL, animaux VARCHAR(255) DEFAULT NULL, discussion VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, marque_voiture VARCHAR(255) DEFAULT NULL, modele_voiture VARCHAR(255) DEFAULT NULL, date_circulation VARCHAR(255) DEFAULT NULL, couleur_voiture VARCHAR(255) DEFAULT NULL, immatriculation_voiture VARCHAR(255) DEFAULT NULL, niveau_confort VARCHAR(255) DEFAULT NULL, identifiant_facebook VARCHAR(255) DEFAULT NULL, identifiant_twitter VARCHAR(255) DEFAULT NULL, identifiant_instagram VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE profil');
    }
}
