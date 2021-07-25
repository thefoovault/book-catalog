<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Book\BookId;
use Faker\Factory;

class BookIdMother
{
    public static function create(string $bookId): BookId
    {
        return new BookId($bookId);
    }

    public static function random(): BookId
    {
        return self::create(Factory::create()->uuid);
    }
}
