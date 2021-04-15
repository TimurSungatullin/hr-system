<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314141835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE history_vacancy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE meeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rating_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resume_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resume_to_owner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vacancy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vacancy_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vacancy_hr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE history_vacancy (id INT NOT NULL, vacancy_id_id INT NOT NULL, resume_id_id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D534057A60AE135 ON history_vacancy (vacancy_id_id)');
        $this->addSql('CREATE INDEX IDX_8D534057E3B35E3F ON history_vacancy (resume_id_id)');
        $this->addSql('CREATE TABLE meeting (id INT NOT NULL, resume_id_id INT NOT NULL, date_meet TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F515E139E3B35E3F ON meeting (resume_id_id)');
        $this->addSql('CREATE TABLE meeting_user (meeting_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(meeting_id, user_id))');
        $this->addSql('CREATE INDEX IDX_61622E9B67433D9C ON meeting_user (meeting_id)');
        $this->addSql('CREATE INDEX IDX_61622E9BA76ED395 ON meeting_user (user_id)');
        $this->addSql('CREATE TABLE rating (id INT NOT NULL, resume_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, status_id_id INT NOT NULL, vacancy_id_id INT DEFAULT NULL, score SMALLINT NOT NULL, comment TEXT DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8892622E3B35E3F ON rating (resume_id_id)');
        $this->addSql('CREATE INDEX IDX_D88926229D86650F ON rating (user_id_id)');
        $this->addSql('CREATE INDEX IDX_D8892622881ECFA7 ON rating (status_id_id)');
        $this->addSql('CREATE INDEX IDX_D8892622A60AE135 ON rating (vacancy_id_id)');
        $this->addSql('CREATE TABLE resume (id INT NOT NULL, hr_id_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, second_name VARCHAR(100) NOT NULL, patronymic VARCHAR(100) DEFAULT NULL, phone VARCHAR(15) NOT NULL, email VARCHAR(50) DEFAULT NULL, graduation TEXT NOT NULL, work_experience TEXT DEFAULT NULL, wage VARCHAR(50) DEFAULT NULL, birth_date DATE DEFAULT NULL, city VARCHAR(255) NOT NULL,PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60C1D0A05965760D ON resume (hr_id_id)');
        $this->addSql('CREATE TABLE resume_to_owner (id INT NOT NULL, resume_id_id INT NOT NULL, owner_id_id INT NOT NULL, is_read BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6ABBFDB9E3B35E3F ON resume_to_owner (resume_id_id)');
        $this->addSql('CREATE INDEX IDX_6ABBFDB98FDDAB70 ON resume_to_owner (owner_id_id)');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(role_id, user_id))');
        $this->addSql('CREATE INDEX IDX_332CA4DDD60322AC ON role_user (role_id)');
        $this->addSql('CREATE INDEX IDX_332CA4DDA76ED395 ON role_user (user_id)');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, first_name VARCHAR(100) NOT NULL, second_name VARCHAR(100) NOT NULL, patronymic VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(100) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vacancy (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vacancy_group (id INT NOT NULL, vacancy_id_id INT NOT NULL, group_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B48E3BA7A60AE135 ON vacancy_group (vacancy_id_id)');
        $this->addSql('CREATE INDEX IDX_B48E3BA72F68B530 ON vacancy_group (group_id_id)');
        $this->addSql('CREATE TABLE vacancy_hr (id INT NOT NULL, hr_id_id INT NOT NULL, vacancy_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AEF4FCD45965760D ON vacancy_hr (hr_id_id)');
        $this->addSql('CREATE INDEX IDX_AEF4FCD4A60AE135 ON vacancy_hr (vacancy_id_id)');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meeting_user ADD CONSTRAINT FK_61622E9B67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meeting_user ADD CONSTRAINT FK_61622E9BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926229D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A05965760D FOREIGN KEY (hr_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT FK_6ABBFDB9E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT FK_6ABBFDB98FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT FK_B48E3BA7A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT FK_B48E3BA72F68B530 FOREIGN KEY (group_id_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT FK_AEF4FCD45965760D FOREIGN KEY (hr_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT FK_AEF4FCD4A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT FK_B48E3BA72F68B530');
        $this->addSql('ALTER TABLE meeting_user DROP CONSTRAINT FK_61622E9B67433D9C');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057E3B35E3F');
        $this->addSql('ALTER TABLE meeting DROP CONSTRAINT FK_F515E139E3B35E3F');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D8892622E3B35E3F');
        $this->addSql('ALTER TABLE resume_to_owner DROP CONSTRAINT FK_6ABBFDB9E3B35E3F');
        $this->addSql('ALTER TABLE role_user DROP CONSTRAINT FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D8892622881ECFA7');
        $this->addSql('ALTER TABLE meeting_user DROP CONSTRAINT FK_61622E9BA76ED395');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D88926229D86650F');
        $this->addSql('ALTER TABLE resume DROP CONSTRAINT FK_60C1D0A05965760D');
        $this->addSql('ALTER TABLE resume_to_owner DROP CONSTRAINT FK_6ABBFDB98FDDAB70');
        $this->addSql('ALTER TABLE role_user DROP CONSTRAINT FK_332CA4DDA76ED395');
        $this->addSql('ALTER TABLE vacancy_hr DROP CONSTRAINT FK_AEF4FCD45965760D');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057A60AE135');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D8892622A60AE135');
        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT FK_B48E3BA7A60AE135');
        $this->addSql('ALTER TABLE vacancy_hr DROP CONSTRAINT FK_AEF4FCD4A60AE135');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE history_vacancy_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE meeting_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rating_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resume_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resume_to_owner_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vacancy_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vacancy_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vacancy_hr_id_seq CASCADE');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE history_vacancy');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE meeting_user');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE resume_to_owner');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE vacancy');
        $this->addSql('DROP TABLE vacancy_group');
        $this->addSql('DROP TABLE vacancy_hr');
    }
}
