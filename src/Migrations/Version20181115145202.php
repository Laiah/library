<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class version20181115145202 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, cover VARCHAR(255) NOT NULL COLLATE BINARY, isbn VARCHAR(13) NOT NULL COLLATE BINARY, authors CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        , CONSTRAINT FK_CBE5A3317E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CBE5A3317E3C61F9 ON book (owner_id)');
        $this->addSql('CREATE TABLE category_book (category_id INTEGER NOT NULL, book_id INTEGER NOT NULL, PRIMARY KEY(book_id, category_id), CONSTRAINT FK_407ED97616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_407ED97612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_407ED97616A2B381 ON category_book (book_id)');
        $this->addSql('CREATE INDEX IDX_407ED97612469DE2 ON category_book (category_id)');
        $this->addSql('CREATE TABLE borrowed_book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, user_id INTEGER NOT NULL, borrowing_date DATE NOT NULL, return_date DATE NOT NULL, has_been_returned BOOLEAN NOT NULL, reservation VARCHAR(20) NOT NULL, has_been_validated BOOLEAN NOT NULL, CONSTRAINT FK_50A9B8BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_50A9B8BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_50A9B8BCA76ED395 ON borrowed_book (user_id)');
        $this->addSql('CREATE INDEX IDX_50A9B8BC16A2B381 ON borrowed_book (book_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(30) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, has_borrowed BOOLEAN NOT NULL)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE borrowed_book');
        $this->addSql('DROP TABLE user');
    }
}
