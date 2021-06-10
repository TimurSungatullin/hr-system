<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210607171354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE assessment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_block_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skill_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE variant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE assessment (id INT NOT NULL, skills_id INT DEFAULT NULL, resumes_id INT DEFAULT NULL, point INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F7523D707FF61858 ON assessment (skills_id)');
        $this->addSql('CREATE INDEX IDX_F7523D709E7F672E ON assessment (resumes_id)');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, title VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, is_variants BOOLEAN NOT NULL, is_many BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question_block (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question_block_question (question_block_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(question_block_id, question_id))');
        $this->addSql('CREATE INDEX IDX_4A820588AE53200 ON question_block_question (question_block_id)');
        $this->addSql('CREATE INDEX IDX_4A820581E27F6BF ON question_block_question (question_id)');
        $this->addSql('CREATE TABLE skill (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skill_vacancy (skill_id INT NOT NULL, vacancy_id INT NOT NULL, PRIMARY KEY(skill_id, vacancy_id))');
        $this->addSql('CREATE INDEX IDX_B3C1F2945585C142 ON skill_vacancy (skill_id)');
        $this->addSql('CREATE INDEX IDX_B3C1F294433B78C4 ON skill_vacancy (vacancy_id)');
        $this->addSql('CREATE TABLE test (id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test_question_block (test_id INT NOT NULL, question_block_id INT NOT NULL, PRIMARY KEY(test_id, question_block_id))');
        $this->addSql('CREATE INDEX IDX_CCBC7E2B1E5D0459 ON test_question_block (test_id)');
        $this->addSql('CREATE INDEX IDX_CCBC7E2B8AE53200 ON test_question_block (question_block_id)');
        $this->addSql('CREATE TABLE user_answer (id INT NOT NULL, question_id INT NOT NULL, resume_id INT NOT NULL, variant_id INT DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF8F51181E27F6BF ON user_answer (question_id)');
        $this->addSql('CREATE INDEX IDX_BF8F5118D262AF09 ON user_answer (resume_id)');
        $this->addSql('CREATE INDEX IDX_BF8F51183B69A9AF ON user_answer (variant_id)');
        $this->addSql('CREATE TABLE user_test (id INT NOT NULL, resume_id INT NOT NULL, test_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2FE32C5D262AF09 ON user_test (resume_id)');
        $this->addSql('CREATE INDEX IDX_A2FE32C51E5D0459 ON user_test (test_id)');
        $this->addSql('CREATE TABLE variant (id INT NOT NULL, question_id INT NOT NULL, answer VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F143BFAD1E27F6BF ON variant (question_id)');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D707FF61858 FOREIGN KEY (skills_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D709E7F672E FOREIGN KEY (resumes_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_block_question ADD CONSTRAINT FK_4A820588AE53200 FOREIGN KEY (question_block_id) REFERENCES question_block (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_block_question ADD CONSTRAINT FK_4A820581E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_vacancy ADD CONSTRAINT FK_B3C1F2945585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_vacancy ADD CONSTRAINT FK_B3C1F294433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_question_block ADD CONSTRAINT FK_CCBC7E2B1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_question_block ADD CONSTRAINT FK_CCBC7E2B8AE53200 FOREIGN KEY (question_block_id) REFERENCES question_block (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F51181E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F51183B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C5D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C51E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE question_block_question DROP CONSTRAINT FK_4A820581E27F6BF');
        $this->addSql('ALTER TABLE user_answer DROP CONSTRAINT FK_BF8F51181E27F6BF');
        $this->addSql('ALTER TABLE variant DROP CONSTRAINT FK_F143BFAD1E27F6BF');
        $this->addSql('ALTER TABLE question_block_question DROP CONSTRAINT FK_4A820588AE53200');
        $this->addSql('ALTER TABLE test_question_block DROP CONSTRAINT FK_CCBC7E2B8AE53200');
        $this->addSql('ALTER TABLE assessment DROP CONSTRAINT FK_F7523D707FF61858');
        $this->addSql('ALTER TABLE skill_vacancy DROP CONSTRAINT FK_B3C1F2945585C142');
        $this->addSql('ALTER TABLE test_question_block DROP CONSTRAINT FK_CCBC7E2B1E5D0459');
        $this->addSql('ALTER TABLE user_test DROP CONSTRAINT FK_A2FE32C51E5D0459');
        $this->addSql('ALTER TABLE user_answer DROP CONSTRAINT FK_BF8F51183B69A9AF');
        $this->addSql('DROP SEQUENCE assessment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_block_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skill_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_test_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE variant_id_seq CASCADE');
        $this->addSql('DROP TABLE assessment');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_block');
        $this->addSql('DROP TABLE question_block_question');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_vacancy');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_question_block');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('DROP TABLE user_test');
        $this->addSql('DROP TABLE variant');
    }
}
