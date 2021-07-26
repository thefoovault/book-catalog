<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\Exception\BookNotFound;

final class GetOneItem
{
    public function __construct(
        private GetItemReadModelRepository $getItemReadModelRepository
    ){}

    public function __invoke(BookId $bookId): ItemResponse
    {
        $item = $this->getItemReadModelRepository->findBookWithAuthorById($bookId);

        if (null === $item) {
            throw new BookNotFound($bookId);
        }

        return $item;
    }
}
