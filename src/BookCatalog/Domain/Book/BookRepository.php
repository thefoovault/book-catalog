<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book;

use BookCatalog\Application\Criteria\Criteria;

interface BookRepository
{
    public function save(Book $book): void;

    public function findBy(Criteria $criteria): BookCollection;
}
