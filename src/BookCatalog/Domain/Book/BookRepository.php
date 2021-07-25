<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book;

interface BookRepository
{
    public function save(Book $book): void;
}
