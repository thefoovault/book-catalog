<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use BookCatalog\Domain\Book\BookId;

interface GetItemReadModelRepository
{
    public function findBookWithAuthorById(BookId $bookId): ?ItemResponse;
}
