<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181123152302 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, cover VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, authors CLOB NOT NULL --(DC2Type:array)
        , slug VARCHAR(128) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
        $this->addSql('CREATE INDEX IDX_CBE5A3317E3C61F9 ON book (owner_id)');
        $this->addSql('CREATE TABLE category_book (book_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(book_id, category_id))');
        $this->addSql('CREATE INDEX IDX_407ED97616A2B381 ON category_book (book_id)');
        $this->addSql('CREATE INDEX IDX_407ED97612469DE2 ON category_book (category_id)');
        $this->addSql('CREATE TABLE borrowed_book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, user_id INTEGER NOT NULL, borrowing_date DATE NOT NULL, return_date DATE NOT NULL, has_been_returned BOOLEAN NOT NULL, reservation VARCHAR(20) NOT NULL, validation_status VARCHAR(15) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_50A9B8BC16A2B381 ON borrowed_book (book_id)');
        $this->addSql('CREATE INDEX IDX_50A9B8BCA76ED395 ON borrowed_book (user_id)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, sort_order INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(30) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, has_borrowed BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('DROP TABLE borrowed_book');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user');
    }
}
