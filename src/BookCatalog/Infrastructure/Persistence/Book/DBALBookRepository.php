<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\Book;

use BookCatalog\Application\Criteria\Criteria;
use BookCatalog\Domain\Author\Author;
use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Author\AuthorName;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookCollection;
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
        $stmt->bindValue('author_id', $book->bookAuthor()->authorId()->value());
        $stmt->bindValue('price', $book->bookPrice()->value());

        $stmt->execute();
    }

    public function findBy(Criteria $criteria): BookCollection
    {
        $query = <<<SQL
SELECT BIN_TO_UUID(b.book_id) AS id, b.image, b.title, BIN_TO_UUID(b.author_id) AS author_id, b.price, a.name AS author_name
FROM book b
JOIN author a ON a.author_id = b.author_id
LIMIT :offset, :limit
SQL;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('offset', $criteria->offset(), ParameterType::INTEGER);
        $stmt->bindValue('limit', $criteria->limit(), ParameterType::INTEGER);

        $stmt->execute();

        $data = $stmt->fetchAllAssociative();

        $bookCollection = new BookCollection([]);

        foreach($data as $book) {
            $bookCollection->add(
                new Book(
                    new BookId($book['id']),
                    new BookImage($book['image']),
                    new BookTitle($book['title']),
                    new Author(
                        new AuthorId($book['author_id']),
                        new AuthorName($book['author_name'])
                    ),
                    new BookPrice((float) $book['price'])
                )
            );
        }

        return $bookCollection;
    }
}
