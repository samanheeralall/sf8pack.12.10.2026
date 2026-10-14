<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261014084934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation ManyToMany Genre et Book';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE book_genre (
              book_id INTEGER NOT NULL,
              genre_id INTEGER NOT NULL,
              PRIMARY KEY (book_id, genre_id),
              CONSTRAINT FK_8D92268116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
              CONSTRAINT FK_8D9226814296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);
        $this->addSql('CREATE INDEX IDX_8D92268116A2B381 ON book_genre (book_id)');
        $this->addSql('CREATE INDEX IDX_8D9226814296D31F ON book_genre (genre_id)');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL)');
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__book AS
            SELECT
              id,
              title,
              isbn,
              summary,
              publication_date,
              available,
              language,
              cover_url
            FROM
              book
        SQL);
        $this->addSql('DROP TABLE book');
        $this->addSql(<<<'SQL'
            CREATE TABLE book (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              title VARCHAR(255) NOT NULL,
              isbn VARCHAR(13) DEFAULT NULL,
              summary CLOB DEFAULT NULL,
              publication_date DATE DEFAULT NULL,
              available BOOLEAN DEFAULT active NOT NULL,
              language VARCHAR(2) DEFAULT NULL,
              cover_url VARCHAR(255) DEFAULT NULL
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO book (
              id, title, isbn, summary, publication_date,
              available, language, cover_url
            )
            SELECT
              id,
              title,
              isbn,
              summary,
              publication_date,
              available,
              language,
              cover_url
            FROM
              __temp__book
        SQL);
        $this->addSql('DROP TABLE __temp__book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__book AS
            SELECT
              id,
              title,
              isbn,
              summary,
              publication_date,
              available,
              language,
              cover_url
            FROM
              book
        SQL);
        $this->addSql('DROP TABLE book');
        $this->addSql(<<<'SQL'
            CREATE TABLE book (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              title VARCHAR(255) NOT NULL,
              isbn VARCHAR(13) DEFAULT NULL,
              summary CLOB DEFAULT NULL,
              publication_date DATE DEFAULT NULL,
              available BOOLEAN NOT NULL,
              language VARCHAR(2) DEFAULT NULL,
              cover_url VARCHAR(255) DEFAULT NULL
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO book (
              id, title, isbn, summary, publication_date,
              available, language, cover_url
            )
            SELECT
              id,
              title,
              isbn,
              summary,
              publication_date,
              available,
              language,
              cover_url
            FROM
              __temp__book
        SQL);
        $this->addSql('DROP TABLE __temp__book');
    }
}
