<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626151448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, quiz_id INT DEFAULT NULL, current_question_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_232B318C5F37A13B (token), INDEX IDX_232B318C853CD175 (quiz_id), UNIQUE INDEX UNIQ_232B318CA0F35D66 (current_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, game_id INT DEFAULT NULL, INDEX IDX_98197A65E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, correct_answer VARCHAR(255) NOT NULL, answers LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, quiz_id INT DEFAULT NULL, INDEX IDX_B6F7494E853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, questions_per_participant INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A412FA925F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game ADD CONSTRAINT FK_232B318C853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game ADD CONSTRAINT FK_232B318CA0F35D66 FOREIGN KEY (current_question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE player ADD CONSTRAINT FK_98197A65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE game DROP FOREIGN KEY FK_232B318C853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game DROP FOREIGN KEY FK_232B318CA0F35D66
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE player DROP FOREIGN KEY FK_98197A65E48FD905
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE player
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
