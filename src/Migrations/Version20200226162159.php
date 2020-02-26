<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226162159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membre');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1440EE8798');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FD77A62A');
        $this->addSql('DROP INDEX IDX_CFBDFA1440EE8798 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA14FD77A62A ON note');
        $this->addSql('ALTER TABLE note ADD membre_note_id INT NOT NULL, ADD membre_notant_id INT NOT NULL, DROP membre_note_id_id, DROP membre_notant_id_id');
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

        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mdp VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, civilite VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statut VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_enregistrement DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1494CA0AE8');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1444D63573');
        $this->addSql('DROP INDEX IDX_CFBDFA1494CA0AE8 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA1444D63573 ON note');
        $this->addSql('ALTER TABLE note ADD membre_note_id_id INT DEFAULT NULL, ADD membre_notant_id_id INT DEFAULT NULL, DROP membre_note_id, DROP membre_notant_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1440EE8798 FOREIGN KEY (membre_note_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FD77A62A FOREIGN KEY (membre_notant_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CFBDFA1440EE8798 ON note (membre_note_id_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FD77A62A ON note (membre_notant_id_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
    }
}
