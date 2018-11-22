<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122105418 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_CBE5A3317E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, owner_id, title, description, cover, isbn, authors FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, cover VARCHAR(255) NOT NULL COLLATE BINARY, isbn VARCHAR(13) NOT NULL COLLATE BINARY, authors CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        , slug VARCHAR(128) NOT NULL, CONSTRAINT FK_CBE5A3317E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, owner_id, title, description, cover, isbn, authors) SELECT id, owner_id, title, description, cover, isbn, authors FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A3317E3C61F9 ON book (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
        $this->addSql('DROP INDEX IDX_407ED97616A2B381');
        $this->addSql('DROP INDEX IDX_407ED97612469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_book AS SELECT category_id, book_id FROM category_book');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('CREATE TABLE category_book (category_id INTEGER NOT NULL, book_id INTEGER NOT NULL, PRIMARY KEY(book_id, category_id), CONSTRAINT FK_407ED97616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_407ED97612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_book (category_id, book_id) SELECT category_id, book_id FROM __temp__category_book');
        $this->addSql('DROP TABLE __temp__category_book');
        $this->addSql('CREATE INDEX IDX_407ED97616A2B381 ON category_book (book_id)');
        $this->addSql('CREATE INDEX IDX_407ED97612469DE2 ON category_book (category_id)');
        $this->addSql('DROP INDEX IDX_50A9B8BCA76ED395');
        $this->addSql('DROP INDEX IDX_50A9B8BC16A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__borrowed_book AS SELECT id, book_id, user_id, borrowing_date, return_date, has_been_returned, has_been_validated, reservation FROM borrowed_book');
        $this->addSql('DROP TABLE borrowed_book');
        $this->addSql('CREATE TABLE borrowed_book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, user_id INTEGER NOT NULL, borrowing_date DATE NOT NULL, return_date DATE NOT NULL, has_been_returned BOOLEAN NOT NULL, has_been_validated BOOLEAN NOT NULL, reservation VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_50A9B8BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_50A9B8BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO borrowed_book (id, book_id, user_id, borrowing_date, return_date, has_been_returned, has_been_validated, reservation) SELECT id, book_id, user_id, borrowing_date, return_date, has_been_returned, has_been_validated, reservation FROM __temp__borrowed_book');
        $this->addSql('DROP TABLE __temp__borrowed_book');
        $this->addSql('CREATE INDEX IDX_50A9B8BCA76ED395 ON borrowed_book (user_id)');
        $this->addSql('CREATE INDEX IDX_50A9B8BC16A2B381 ON borrowed_book (book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_CBE5A331989D9B62');
        $this->addSql('DROP INDEX IDX_CBE5A3317E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, owner_id, title, description, cover, isbn, authors FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, cover VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, authors CLOB NOT NULL --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO book (id, owner_id, title, description, cover, isbn, authors) SELECT id, owner_id, title, description, cover, isbn, authors FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A3317E3C61F9 ON book (owner_id)');
        $this->addSql('DROP INDEX IDX_50A9B8BC16A2B381');
        $this->addSql('DROP INDEX IDX_50A9B8BCA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__borrowed_book AS SELECT id, book_id, user_id, borrowing_date, return_date, has_been_returned, reservation, has_been_validated FROM borrowed_book');
        $this->addSql('DROP TABLE borrowed_book');
        $this->addSql('CREATE TABLE borrowed_book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, user_id INTEGER NOT NULL, borrowing_date DATE NOT NULL, return_date DATE NOT NULL, has_been_returned BOOLEAN NOT NULL, reservation VARCHAR(255) NOT NULL, has_been_validated BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO borrowed_book (id, book_id, user_id, borrowing_date, return_date, has_been_returned, reservation, has_been_validated) SELECT id, book_id, user_id, borrowing_date, return_date, has_been_returned, reservation, has_been_validated FROM __temp__borrowed_book');
        $this->addSql('DROP TABLE __temp__borrowed_book');
        $this->addSql('CREATE INDEX IDX_50A9B8BC16A2B381 ON borrowed_book (book_id)');
        $this->addSql('CREATE INDEX IDX_50A9B8BCA76ED395 ON borrowed_book (user_id)');
        $this->addSql('DROP INDEX IDX_407ED97616A2B381');
        $this->addSql('DROP INDEX IDX_407ED97612469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_book AS SELECT book_id, category_id FROM category_book');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('CREATE TABLE category_book (book_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(book_id, category_id))');
        $this->addSql('INSERT INTO category_book (book_id, category_id) SELECT book_id, category_id FROM __temp__category_book');
        $this->addSql('DROP TABLE __temp__category_book');
        $this->addSql('CREATE INDEX IDX_407ED97616A2B381 ON category_book (book_id)');
        $this->addSql('CREATE INDEX IDX_407ED97612469DE2 ON category_book (category_id)');
    }
}
