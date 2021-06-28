<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625123041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, message, tags, picture, datetime FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, message VARCHAR(255) NOT NULL COLLATE BINARY, tags VARCHAR(255) NOT NULL COLLATE BINARY, picture VARCHAR(255) NOT NULL COLLATE BINARY, datetime DATETIME NOT NULL, CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES duck (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, author_id, message, tags, picture, datetime) SELECT id, author_id, message, tags, picture, datetime FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('DROP INDEX IDX_245D90EDF675F31B');
        $this->addSql('DROP INDEX IDX_245D90EDD3950CA9');
        $this->addSql('DROP INDEX UNIQ_245D90EDBFB6ED23');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_comment AS SELECT id, quack_id, author_id, delete_comment_id, comment FROM quack_comment');
        $this->addSql('DROP TABLE quack_comment');
        $this->addSql('CREATE TABLE quack_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quack_id INTEGER NOT NULL, author_id INTEGER DEFAULT NULL, delete_comment_id INTEGER DEFAULT NULL, comment VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_245D90EDD3950CA9 FOREIGN KEY (quack_id) REFERENCES quack (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_245D90EDF675F31B FOREIGN KEY (author_id) REFERENCES duck (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_245D90EDBFB6ED23 FOREIGN KEY (delete_comment_id) REFERENCES quack_comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack_comment (id, quack_id, author_id, delete_comment_id, comment) SELECT id, quack_id, author_id, delete_comment_id, comment FROM __temp__quack_comment');
        $this->addSql('DROP TABLE __temp__quack_comment');
        $this->addSql('CREATE INDEX IDX_245D90EDF675F31B ON quack_comment (author_id)');
        $this->addSql('CREATE INDEX IDX_245D90EDD3950CA9 ON quack_comment (quack_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_245D90EDBFB6ED23 ON quack_comment (delete_comment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, message, picture, datetime, tags FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, message VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, tags VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO quack (id, author_id, message, picture, datetime, tags) SELECT id, author_id, message, picture, datetime, tags FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('DROP INDEX IDX_245D90EDD3950CA9');
        $this->addSql('DROP INDEX IDX_245D90EDF675F31B');
        $this->addSql('DROP INDEX UNIQ_245D90EDBFB6ED23');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_comment AS SELECT id, quack_id, author_id, delete_comment_id, comment FROM quack_comment');
        $this->addSql('DROP TABLE quack_comment');
        $this->addSql('CREATE TABLE quack_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quack_id INTEGER NOT NULL, author_id INTEGER DEFAULT NULL, delete_comment_id INTEGER DEFAULT NULL, comment VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO quack_comment (id, quack_id, author_id, delete_comment_id, comment) SELECT id, quack_id, author_id, delete_comment_id, comment FROM __temp__quack_comment');
        $this->addSql('DROP TABLE __temp__quack_comment');
        $this->addSql('CREATE INDEX IDX_245D90EDD3950CA9 ON quack_comment (quack_id)');
        $this->addSql('CREATE INDEX IDX_245D90EDF675F31B ON quack_comment (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_245D90EDBFB6ED23 ON quack_comment (delete_comment_id)');
    }
}
