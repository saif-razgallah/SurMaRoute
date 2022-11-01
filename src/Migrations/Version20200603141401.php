<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603141401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE avis ADD noter_id INT DEFAULT NULL, ADD est_note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF044EA9233 FOREIGN KEY (noter_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0CDB21195 FOREIGN KEY (est_note_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF044EA9233 ON avis (noter_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0CDB21195 ON avis (est_note_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF044EA9233');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0CDB21195');
        $this->addSql('DROP INDEX IDX_8F91ABF044EA9233 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0CDB21195 ON avis');
        $this->addSql('ALTER TABLE avis DROP noter_id, DROP est_note_id');
    }
}
