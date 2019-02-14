<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214204848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE questions ADD question_text_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D56751E055 FOREIGN KEY (question_text_id) REFERENCES answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8ADC54D56751E055 ON questions (question_text_id)');
        $this->addSql('ALTER TABLE "user" ALTER nick TYPE VARCHAR(50)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649290B2F37 ON "user" (nick)');
        $this->addSql('ALTER TABLE answer ADD answer_text_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD question_id INT NOT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2521CDFA39 FOREIGN KEY (answer_text_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DADD4A2521CDFA39 ON answer (answer_text_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_8D93D649290B2F37');
        $this->addSql('ALTER TABLE "user" ALTER nick TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D56751E055');
        $this->addSql('DROP INDEX UNIQ_8ADC54D56751E055');
        $this->addSql('ALTER TABLE questions DROP question_text_id');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A2521CDFA39');
        $this->addSql('DROP INDEX UNIQ_DADD4A251E27F6BF');
        $this->addSql('DROP INDEX UNIQ_DADD4A2521CDFA39');
        $this->addSql('ALTER TABLE answer DROP answer_text_id');
        $this->addSql('ALTER TABLE answer DROP question_id');
    }
}
