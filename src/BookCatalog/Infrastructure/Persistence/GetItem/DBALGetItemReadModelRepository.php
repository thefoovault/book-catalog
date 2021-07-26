<?php

declare(strict_types=1);

namespace BookCatalog\Infrastructure\Persistence\GetItem;

use BookCatalog\Application\GetOneItem\GetItemReadModelRepository;
use BookCatalog\Application\GetOneItem\ItemResponse;
use BookCatalog\Domain\Book\BookId;
use Doctrine\DBAL\Driver\Connection;

final class DBALGetItemReadModelRepository implements GetItemReadModelRepository
{
    public function __construct(
        private Connection $connection
    ){}

    public function findBookWithAuthorById(BookId $bookId): ?ItemResponse
    {
        $query = <<<SQL
SELECT BIN_TO_UUID(b.book_id) AS id, b.image, b.title, a.name AS author, b.price
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

        return ItemResponse::create(current($data));
    }
}
