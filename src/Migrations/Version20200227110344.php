<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227110344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1494CA0AE8 FOREIGN KEY (membre_note_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1444D63573 FOREIGN KEY (membre_notant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1494CA0AE8 ON note (membre_note_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1444D63573 ON note (membre_notant_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1494CA0AE8');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1444D63573');
        $this->addSql('DROP INDEX IDX_CFBDFA1494CA0AE8 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA1444D63573 ON note');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
    }
}
