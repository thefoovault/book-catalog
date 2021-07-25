<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Author;

use BookCatalog\Domain\Author\AuthorName;
use Faker\Factory;

class AuthorNameMother
{
    public static function create(string $name): AuthorName
    {
        return new AuthorName($name);
    }

    public static function random(): AuthorName
    {
        return self::create(Factory::create()->name);
    }
}
