<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\Author;

use BookCatalog\Domain\Author\Author;
use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Author\AuthorName;
use BookCatalog\Domain\Author\AuthorRepository;
use Doctrine\DBAL\Driver\Connection;

final class DBALAuthorRepository implements AuthorRepository
{
    public function __construct(
        private Connection $connection
    ){}

    public function save(Author $author): void
    {
        $query = <<<SQL
INSERT INTO author (author_id, name) 
VALUES (UUID_TO_BIN(:id), :name)
SQL;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('id', $author->authorId()->value());
        $stmt->bindValue('name', $author->authorName()->value());

        $stmt->execute();
    }

    public function findById(AuthorId $authorId): ?Author
    {
        $query = <<<SQL
SELECT BIN_TO_UUID(author_id) AS id, name
FROM author
WHERE author_id = UUID_TO_BIN(:id)
SQL;
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('id', $authorId->value());
        $stmt->execute();
        $data = $stmt->fetchAllAssociative();
        if (false === $data) {
            return null;
        }
        return $this->hydrateItem($data);
    }

    private function hydrateItem(array $data): Author
    {
        $current = current($data);
        $authorId = new AuthorId($current['id']);
        $authorName = new AuthorName($current['name']);
        return new Author($authorId, $authorName);
    }
}
