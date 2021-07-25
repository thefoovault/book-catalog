<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Book\BookPrice;
use Faker\Factory;

class BookPriceMother
{
    private const MAX_DECIMALS = 2;
    private const MIN_NUMBER = 0;
    private const MAX_NUMBER = 100;

    public static function create(float $bookPrice): BookPrice
    {
        return new BookPrice($bookPrice);
    }

    public static function random(): BookPrice
    {
        return self::create(Factory::create()->randomFloat(self::MAX_DECIMALS, self::MIN_NUMBER, self::MAX_NUMBER));
    }
}
