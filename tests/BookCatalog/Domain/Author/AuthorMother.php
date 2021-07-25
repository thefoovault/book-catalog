<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Author;

use BookCatalog\Domain\Author\Author;
use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Author\AuthorName;

final class AuthorMother
{
    public static function create(AuthorId $authorId, AuthorName $authorName): Author
    {
        return new Author($authorId, $authorName);
    }

    public static function random(): Author
    {
        return self::create(
            AuthorIdMother::random(),
            AuthorNameMother::random()
        );
    }
}
