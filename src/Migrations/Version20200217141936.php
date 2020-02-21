<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200217141936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce ADD membre_id_id INT DEFAULT NULL, ADD photo_id_id INT DEFAULT NULL, ADD categorie_id_id INT DEFAULT NULL, DROP membre_id, DROP photo_id, DROP categorie_id');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C96291D6 FOREIGN KEY (membre_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C51599E0 FOREIGN KEY (photo_id_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E58A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5C96291D6 ON annonce (membre_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F65593E5C51599E0 ON annonce (photo_id_id)');
        $this->addSql('CREATE INDEX IDX_F65593E58A3C7387 ON annonce (categorie_id_id)');
        $this->addSql('ALTER TABLE commentaire ADD membre_id_id INT DEFAULT NULL, ADD annonce_id_id INT DEFAULT NULL, DROP membre_id, DROP annonce_id');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC96291D6 FOREIGN KEY (membre_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC68C955C8 FOREIGN KEY (annonce_id_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCC96291D6 ON commentaire (membre_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67F068BC68C955C8 ON commentaire (annonce_id_id)');
        $this->addSql('ALTER TABLE note ADD membre_note_id_id INT DEFAULT NULL, ADD membre_notant_id_id INT DEFAULT NULL, DROP membre_note_id, DROP membre_notant_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1440EE8798 FOREIGN KEY (membre_note_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FD77A62A FOREIGN KEY (membre_notant_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1440EE8798 ON note (membre_note_id_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FD77A62A ON note (membre_notant_id_id)');
        $this->addSql('DROP INDEX pseudo ON user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C96291D6');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C51599E0');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E58A3C7387');
        $this->addSql('DROP INDEX IDX_F65593E5C96291D6 ON annonce');
        $this->addSql('DROP INDEX UNIQ_F65593E5C51599E0 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E58A3C7387 ON annonce');
        $this->addSql('ALTER TABLE annonce ADD membre_id INT NOT NULL, ADD photo_id INT NOT NULL, ADD categorie_id INT NOT NULL, DROP membre_id_id, DROP photo_id_id, DROP categorie_id_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC96291D6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC68C955C8');
        $this->addSql('DROP INDEX IDX_67F068BCC96291D6 ON commentaire');
        $this->addSql('DROP INDEX UNIQ_67F068BC68C955C8 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD membre_id INT NOT NULL, ADD annonce_id INT NOT NULL, DROP membre_id_id, DROP annonce_id_id');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1440EE8798');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FD77A62A');
        $this->addSql('DROP INDEX IDX_CFBDFA1440EE8798 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA14FD77A62A ON note');
        $this->addSql('ALTER TABLE note ADD membre_note_id INT NOT NULL, ADD membre_notant_id INT NOT NULL, DROP membre_note_id_id, DROP membre_notant_id_id');
        $this->addSql('CREATE UNIQUE INDEX pseudo ON user (pseudo)');
    }
}
