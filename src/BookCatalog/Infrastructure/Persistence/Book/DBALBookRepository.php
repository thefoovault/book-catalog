<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\Book;

use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookRepository;
use Doctrine\DBAL\Driver\Connection;

final class DBALBookRepository implements BookRepository
{
    public function __construct(
        private Connection $connection
    ){}

    public function save(Book $book): void
    {
        $query = <<<SQL
INSERT INTO book (book_id, image, title, author_id, price) 
VALUES (UUID_TO_BIN(:id), :image, :title, UUID_TO_BIN(:author_id), :price)
SQL;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('id', $book->bookId()->value());
        $stmt->bindValue('image', $book->bookImage()->value());
        $stmt->bindValue('title', $book->bookTitle()->value());
        $stmt->bindValue('author_id', $book->bookAuthor()->value());
        $stmt->bindValue('price', $book->bookPrice()->value());

        $stmt->execute();
    }
}
