<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Book\BookTitle;
use Faker\Factory;

class BookTitleMother
{
    public static function create(string $bookTitle): BookTitle
    {
        return new BookTitle($bookTitle);
    }

    public static function random(): BookTitle
    {
        return self::create(Factory::create()->title);
    }
}
