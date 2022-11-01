<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412160247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, type_utilisateur VARCHAR(255) DEFAULT NULL, ville_depart VARCHAR(255) DEFAULT NULL, ville_arrivee VARCHAR(255) DEFAULT NULL, date_depart DATETIME DEFAULT NULL, heure_depart TIME DEFAULT NULL, autoroute VARCHAR(255) DEFAULT NULL, frequence VARCHAR(255) DEFAULT NULL, type_trajet VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, distance VARCHAR(255) DEFAULT NULL, duree_estimee VARCHAR(255) DEFAULT NULL, nbr_place INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trajet');
    }
}
