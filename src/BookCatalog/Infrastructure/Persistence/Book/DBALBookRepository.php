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

    public function findById(BookId $bookId): ?Book
    {
        $query = <<<SQL
SELECT BIN_TO_UUID(b.book_id) AS id, b.image, b.title, BIN_TO_UUID(a.author_id) AS author_id, a.name AS author_name, b.price
FROM book b
JOIN author a ON a.author_id = b.author_id 
WHERE b.book_id = UUID_TO_BIN(:id)
SQL;
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('id', $bookId->value());

        $stmt->execute();

        $data = $stmt->fetchAllAssociative();

        if (!$data) {
            return null;
        }

        return $this->hydrateItem(current($data));
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

        return $this->hydrateItems($data);
    }

    private function hydrateItem(array $current): Book
    {
        $bookId = new BookId($current['id']);
        $bookImage = new BookImage($current['image']);
        $bookTitle = new BookTitle($current['title']);
        $author = new Author(
            new AuthorId($current['author_id']),
            new AuthorName($current['author_name'])
        );
        $bookPrice = new BookPrice((float) $current['price']);

        return new Book($bookId, $bookImage, $bookTitle, $author, $bookPrice);
    }

    /**
     * @param $data
     * @return BookCollection
     */
    private function hydrateItems($data): BookCollection
    {
        $bookCollection = new BookCollection([]);

        foreach ($data as $book) {
            $bookCollection->add(
                $this->hydrateItem($book)
            );
        }
        return $bookCollection;
    }
}
