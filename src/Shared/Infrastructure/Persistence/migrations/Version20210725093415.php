<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210725093415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created Author and Book';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (author_id VARBINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (book_id VARBINARY(16) NOT NULL, image VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, author_id VARBINARY(16) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_AUTHOR_ID FOREIGN KEY (author_id) REFERENCES author (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE author');
    }
}
