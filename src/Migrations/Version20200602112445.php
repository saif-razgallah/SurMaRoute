<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602112445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD envoie_id INT DEFAULT NULL, ADD reception_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638425C347D FOREIGN KEY (envoie_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6387C14DF52 FOREIGN KEY (reception_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638425C347D ON contact (envoie_id)');
        $this->addSql('CREATE INDEX IDX_4C62E6387C14DF52 ON contact (reception_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638425C347D');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6387C14DF52');
        $this->addSql('DROP INDEX IDX_4C62E638425C347D ON contact');
        $this->addSql('DROP INDEX IDX_4C62E6387C14DF52 ON contact');
        $this->addSql('ALTER TABLE contact DROP envoie_id, DROP reception_id');
    }
}
