<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\Author;

use BookCatalog\Domain\Author\Author;
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
}
