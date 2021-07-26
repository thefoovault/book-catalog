<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\Book;

use BookCatalog\Application\Criteria\Criteria;
use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\BookImage;
use BookCatalog\Domain\Book\BookPrice;
use BookCatalog\Domain\Book\BookRepository;
use BookCatalog\Domain\Book\BookTitle;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\ParameterType;

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

    public function findBy(Criteria $criteria): ?iterable
    {
        $query = <<<SQL
SELECT BIN_TO_UUID(book_id) AS id, image, title, BIN_TO_UUID(author_id) AS author_id, price
FROM book
 LIMIT :offset, :limit
SQL;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('offset', $criteria->offset(), ParameterType::INTEGER);
        $stmt->bindValue('limit', $criteria->limit(), ParameterType::INTEGER);

        $stmt->execute();

        $data = $stmt->fetchAllAssociative();

        if (empty($data) || false === $data) {
            return null;
        }

        foreach($data as $book) {
            yield new Book(
                new BookId($book['id']),
                new BookImage($book['image']),
                new BookTitle($book['title']),
                new AuthorId($book['author_id']),
                new BookPrice((float) $book['price'])
            );
        }
    }
}
