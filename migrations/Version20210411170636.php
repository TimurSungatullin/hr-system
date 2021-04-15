<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411170636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT fk_8d534057a60ae135');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT fk_8d534057e3b35e3f');
        $this->addSql('DROP INDEX idx_8d534057e3b35e3f');
        $this->addSql('DROP INDEX idx_8d534057a60ae135');
        $this->addSql('ALTER TABLE history_vacancy ADD vacancy_id INT NOT NULL');
        $this->addSql('ALTER TABLE history_vacancy ADD resume_id INT NOT NULL');
        $this->addSql('ALTER TABLE history_vacancy DROP vacancy_id_id');
        $this->addSql('ALTER TABLE history_vacancy DROP resume_id_id');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT FK_8D534057D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D534057433B78C4 ON history_vacancy (vacancy_id)');
        $this->addSql('CREATE INDEX IDX_8D534057D262AF09 ON history_vacancy (resume_id)');

        $this->addSql('ALTER TABLE meeting DROP CONSTRAINT fk_f515e139e3b35e3f');
        $this->addSql('DROP INDEX idx_f515e139e3b35e3f');
        $this->addSql('ALTER TABLE meeting RENAME COLUMN resume_id_id TO resume_id');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F515E139D262AF09 ON meeting (resume_id)');

        $this->addSql('ALTER TABLE rating DROP CONSTRAINT fk_d8892622e3b35e3f');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT fk_d8892622881ecfa7');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT fk_d8892622a60ae135');
        $this->addSql('DROP INDEX idx_d8892622e3b35e3f');
        $this->addSql('DROP INDEX idx_d8892622a60ae135');
        $this->addSql('DROP INDEX idx_d8892622881ecfa7');
        $this->addSql('DROP INDEX idx_d88926229d86650f');
        $this->addSql('ALTER TABLE rating ADD resume_id INT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD vacancy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating DROP resume_id_id');
        $this->addSql('ALTER TABLE rating DROP user_id_id');
        $this->addSql('ALTER TABLE rating DROP status_id_id');
        $this->addSql('ALTER TABLE rating DROP vacancy_id_id');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926226BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D8892622D262AF09 ON rating (resume_id)');
        $this->addSql('CREATE INDEX IDX_D8892622A76ED395 ON rating (user_id)');
        $this->addSql('CREATE INDEX IDX_D88926226BF700BD ON rating (status_id)');
        $this->addSql('CREATE INDEX IDX_D8892622433B78C4 ON rating (vacancy_id)');

        $this->addSql('DROP INDEX idx_60c1d0a05965760d');
        $this->addSql('ALTER TABLE resume RENAME COLUMN hr_id_id TO hr_id');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A03756BFA4 FOREIGN KEY (hr_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_60C1D0A03756BFA4 ON resume (hr_id)');

        $this->addSql('ALTER TABLE resume_to_owner DROP CONSTRAINT fk_6abbfdb9e3b35e3f');
        $this->addSql('DROP INDEX idx_6abbfdb98fddab70');
        $this->addSql('DROP INDEX idx_6abbfdb9e3b35e3f');
        $this->addSql('ALTER TABLE resume_to_owner ADD resume_id INT NOT NULL');
        $this->addSql('ALTER TABLE resume_to_owner ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE resume_to_owner DROP resume_id_id');
        $this->addSql('ALTER TABLE resume_to_owner DROP owner_id_id');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT FK_6ABBFDB9D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT FK_6ABBFDB97E3C61F9 FOREIGN KEY (owner_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6ABBFDB9D262AF09 ON resume_to_owner (resume_id)');
        $this->addSql('CREATE INDEX IDX_6ABBFDB97E3C61F9 ON resume_to_owner (owner_id)');

        $this->addSql('ALTER TABLE status_history DROP CONSTRAINT fk_2f6a07cee3b35e3f');
        $this->addSql('ALTER TABLE status_history DROP CONSTRAINT fk_2f6a07ce881ecfa7');
        $this->addSql('DROP INDEX idx_2f6a07ce881ecfa7');
        $this->addSql('DROP INDEX idx_2f6a07cee3b35e3f');
        $this->addSql('ALTER TABLE status_history ADD resume_id INT NOT NULL');
        $this->addSql('ALTER TABLE status_history ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE status_history DROP resume_id_id');
        $this->addSql('ALTER TABLE status_history DROP status_id_id');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CED262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2F6A07CED262AF09 ON status_history (resume_id)');
        $this->addSql('CREATE INDEX IDX_2F6A07CE6BF700BD ON status_history (status_id)');

        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT fk_b48e3ba7a60ae135');
        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT fk_b48e3ba72f68b530');
        $this->addSql('DROP INDEX idx_b48e3ba7a60ae135');
        $this->addSql('DROP INDEX idx_b48e3ba72f68b530');
        $this->addSql('ALTER TABLE vacancy_group ADD vacancy_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_group ADD group_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_group DROP vacancy_id_id');
        $this->addSql('ALTER TABLE vacancy_group DROP group_id_id');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT FK_B48E3BA7433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT FK_B48E3BA7FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B48E3BA7433B78C4 ON vacancy_group (vacancy_id)');
        $this->addSql('CREATE INDEX IDX_B48E3BA7FE54D947 ON vacancy_group (group_id)');

        $this->addSql('ALTER TABLE vacancy_hr DROP CONSTRAINT fk_aef4fcd4a60ae135');
        $this->addSql('DROP INDEX idx_aef4fcd4a60ae135');
        $this->addSql('DROP INDEX idx_aef4fcd45965760d');
        $this->addSql('ALTER TABLE vacancy_hr ADD hr_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_hr ADD vacancy_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_hr DROP hr_id_id');
        $this->addSql('ALTER TABLE vacancy_hr DROP vacancy_id_id');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT FK_AEF4FCD43756BFA4 FOREIGN KEY (hr_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT FK_AEF4FCD4433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AEF4FCD43756BFA4 ON vacancy_hr (hr_id)');
        $this->addSql('CREATE INDEX IDX_AEF4FCD4433B78C4 ON vacancy_hr (vacancy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057433B78C4');
        $this->addSql('ALTER TABLE history_vacancy DROP CONSTRAINT FK_8D534057D262AF09');
        $this->addSql('DROP INDEX IDX_8D534057433B78C4');
        $this->addSql('DROP INDEX IDX_8D534057D262AF09');
        $this->addSql('ALTER TABLE history_vacancy ADD vacancy_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE history_vacancy ADD resume_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE history_vacancy DROP vacancy_id');
        $this->addSql('ALTER TABLE history_vacancy DROP resume_id');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT fk_8d534057a60ae135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE history_vacancy ADD CONSTRAINT fk_8d534057e3b35e3f FOREIGN KEY (resume_id_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d534057e3b35e3f ON history_vacancy (resume_id_id)');
        $this->addSql('CREATE INDEX idx_8d534057a60ae135 ON history_vacancy (vacancy_id_id)');
        $this->addSql('ALTER TABLE meeting DROP CONSTRAINT FK_F515E139D262AF09');
        $this->addSql('DROP INDEX IDX_F515E139D262AF09');
        $this->addSql('ALTER TABLE meeting RENAME COLUMN resume_id TO resume_id_id');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT fk_f515e139e3b35e3f FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f515e139e3b35e3f ON meeting (resume_id_id)');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D8892622D262AF09');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D88926226BF700BD');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D8892622433B78C4');
        $this->addSql('DROP INDEX IDX_D8892622D262AF09');
        $this->addSql('DROP INDEX IDX_D8892622A76ED395');
        $this->addSql('DROP INDEX IDX_D88926226BF700BD');
        $this->addSql('DROP INDEX IDX_D8892622433B78C4');
        $this->addSql('ALTER TABLE rating ADD resume_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD status_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD vacancy_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating DROP resume_id');
        $this->addSql('ALTER TABLE rating DROP user_id');
        $this->addSql('ALTER TABLE rating DROP status_id');
        $this->addSql('ALTER TABLE rating DROP vacancy_id');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT fk_d8892622e3b35e3f FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT fk_d88926229d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT fk_d8892622881ecfa7 FOREIGN KEY (status_id_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT fk_d8892622a60ae135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d8892622e3b35e3f ON rating (resume_id_id)');
        $this->addSql('CREATE INDEX idx_d8892622a60ae135 ON rating (vacancy_id_id)');
        $this->addSql('CREATE INDEX idx_d8892622881ecfa7 ON rating (status_id_id)');
        $this->addSql('CREATE INDEX idx_d88926229d86650f ON rating (user_id_id)');
        $this->addSql('DROP INDEX IDX_60C1D0A03756BFA4');
        $this->addSql('ALTER TABLE resume RENAME COLUMN hr_id TO hr_id_id');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT fk_60c1d0a05965760d FOREIGN KEY (hr_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_60c1d0a05965760d ON resume (hr_id_id)');
        $this->addSql('ALTER TABLE resume_to_owner DROP CONSTRAINT FK_6ABBFDB9D262AF09');
        $this->addSql('DROP INDEX IDX_6ABBFDB9D262AF09');
        $this->addSql('DROP INDEX IDX_6ABBFDB97E3C61F9');
        $this->addSql('ALTER TABLE resume_to_owner ADD resume_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE resume_to_owner ADD owner_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE resume_to_owner DROP resume_id');
        $this->addSql('ALTER TABLE resume_to_owner DROP owner_id');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT fk_6abbfdb9e3b35e3f FOREIGN KEY (resume_id_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_to_owner ADD CONSTRAINT fk_6abbfdb98fddab70 FOREIGN KEY (owner_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6abbfdb98fddab70 ON resume_to_owner (owner_id_id)');
        $this->addSql('CREATE INDEX idx_6abbfdb9e3b35e3f ON resume_to_owner (resume_id_id)');
        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT FK_B48E3BA7433B78C4');
        $this->addSql('ALTER TABLE vacancy_group DROP CONSTRAINT FK_B48E3BA7FE54D947');
        $this->addSql('DROP INDEX IDX_B48E3BA7433B78C4');
        $this->addSql('DROP INDEX IDX_B48E3BA7FE54D947');
        $this->addSql('ALTER TABLE vacancy_group ADD vacancy_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_group ADD group_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_group DROP vacancy_id');
        $this->addSql('ALTER TABLE vacancy_group DROP group_id');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT fk_b48e3ba7a60ae135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_group ADD CONSTRAINT fk_b48e3ba72f68b530 FOREIGN KEY (group_id_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b48e3ba7a60ae135 ON vacancy_group (vacancy_id_id)');
        $this->addSql('CREATE INDEX idx_b48e3ba72f68b530 ON vacancy_group (group_id_id)');
        $this->addSql('ALTER TABLE vacancy_hr DROP CONSTRAINT FK_AEF4FCD4433B78C4');
        $this->addSql('DROP INDEX IDX_AEF4FCD43756BFA4');
        $this->addSql('DROP INDEX IDX_AEF4FCD4433B78C4');
        $this->addSql('ALTER TABLE vacancy_hr ADD hr_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_hr ADD vacancy_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancy_hr DROP hr_id');
        $this->addSql('ALTER TABLE vacancy_hr DROP vacancy_id');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT fk_aef4fcd45965760d FOREIGN KEY (hr_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancy_hr ADD CONSTRAINT fk_aef4fcd4a60ae135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_aef4fcd4a60ae135 ON vacancy_hr (vacancy_id_id)');
        $this->addSql('CREATE INDEX idx_aef4fcd45965760d ON vacancy_hr (hr_id_id)');
        $this->addSql('ALTER TABLE status_history DROP CONSTRAINT FK_2F6A07CED262AF09');
        $this->addSql('ALTER TABLE status_history DROP CONSTRAINT FK_2F6A07CE6BF700BD');
        $this->addSql('DROP INDEX IDX_2F6A07CED262AF09');
        $this->addSql('DROP INDEX IDX_2F6A07CE6BF700BD');
        $this->addSql('ALTER TABLE status_history ADD resume_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE status_history ADD status_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE status_history DROP resume_id');
        $this->addSql('ALTER TABLE status_history DROP status_id');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT fk_2f6a07cee3b35e3f FOREIGN KEY (resume_id_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT fk_2f6a07ce881ecfa7 FOREIGN KEY (status_id_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2f6a07ce881ecfa7 ON status_history (status_id_id)');
        $this->addSql('CREATE INDEX idx_2f6a07cee3b35e3f ON status_history (resume_id_id)');
    }
}
