<?php

declare(strict_types=1);

namespace BookCatalog\Application\CreateItem;

use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookRepository;

final class CreateItem
{
    public function __construct(
        private BookRepository $bookRepository
    ){}

    public function __invoke(Book $book): void
    {
        $this->bookRepository->save($book);
    }
}
