<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327140346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE resume_status (resume_id INT NOT NULL, status_id INT NOT NULL, PRIMARY KEY(resume_id, status_id))');
        $this->addSql('CREATE INDEX IDX_38F57BB6D262AF09 ON resume_status (resume_id)');
        $this->addSql('CREATE INDEX IDX_38F57BB66BF700BD ON resume_status (status_id)');
        $this->addSql('ALTER TABLE resume_status ADD CONSTRAINT FK_38F57BB6D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_status ADD CONSTRAINT FK_38F57BB66BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE resume_status');
    }
}
