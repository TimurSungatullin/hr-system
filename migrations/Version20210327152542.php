<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327152542 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057A60AE135');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057E3B35E3F');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057A60AE135');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057E3B35E3F');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
