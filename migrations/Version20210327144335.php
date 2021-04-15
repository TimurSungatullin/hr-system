<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327144335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE status_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE status_history (id INT NOT NULL, resume_id_id INT NOT NULL, status_id_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F6A07CEE3B35E3F ON status_history (resume_id_id)');
        $this->addSql('CREATE INDEX IDX_2F6A07CE881ECFA7 ON status_history (status_id_id)');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CEE3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CE881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE resume_status');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE status_history_id_seq CASCADE');
        $this->addSql('CREATE TABLE resume_status (resume_id INT NOT NULL, status_id INT NOT NULL, PRIMARY KEY(resume_id, status_id))');
        $this->addSql('CREATE INDEX idx_38f57bb66bf700bd ON resume_status (status_id)');
        $this->addSql('CREATE INDEX idx_38f57bb6d262af09 ON resume_status (resume_id)');
        $this->addSql('ALTER TABLE resume_status ADD CONSTRAINT fk_38f57bb6d262af09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_status ADD CONSTRAINT fk_38f57bb66bf700bd FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE status_history');
    }
}
