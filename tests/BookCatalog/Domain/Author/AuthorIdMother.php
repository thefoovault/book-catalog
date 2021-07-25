<?php

declare(strict_types=1);


namespace Test\BookCatalog\Domain\Author;


use BookCatalog\Domain\Author\AuthorId;
use Faker\Factory;

class AuthorIdMother
{
    public static function create(string $bookId): AuthorId
    {
        return new AuthorId($bookId);
    }

    public static function random(): AuthorId
    {
        return self::create(Factory::create()->uuid);
    }
}
