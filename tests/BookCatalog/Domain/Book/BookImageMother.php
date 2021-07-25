<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Book\BookImage;
use Faker\Factory;

class BookImageMother
{
    public static function create(string $bookImage): BookImage
    {
        return new BookImage($bookImage);
    }

    public static function random(): BookImage
    {
        return self::create(Factory::create()->imageUrl());
    }
}
