<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\BookRepository;
use BookCatalog\Domain\Book\Exception\BookNotFound;

final class GetOneItem
{
    public function __construct(
        private BookRepository $bookRepository
    ){}

    public function __invoke(BookId $bookId): Book
    {
        $book = $this->bookRepository->findById($bookId); //$this->getItemReadModelRepository->findBookWithAuthorById($bookId);

        if (null === $book) {
            throw new BookNotFound($bookId);
        }

        return $book;
    }
}
