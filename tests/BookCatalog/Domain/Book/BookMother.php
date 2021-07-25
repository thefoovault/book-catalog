<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\BookImage;
use BookCatalog\Domain\Book\BookPrice;
use BookCatalog\Domain\Book\BookTitle;
use Test\BookCatalog\Domain\Author\AuthorIdMother;

final class BookMother
{
    public static function create(
        BookId $bookId,
        BookImage $bookImage,
        BookTitle $bookTitle,
        AuthorId $authorId,
        BookPrice $bookPrice
    ): Book
    {
        return new Book($bookId, $bookImage, $bookTitle, $authorId, $bookPrice);
    }

    public static function random(): Book
    {
        return self::create(
            BookIdMother::random(),
            BookImageMother::random(),
            BookTitleMother::random(),
            AuthorIdMother::random(),
            BookPriceMother::random()
        );
    }

    public static function withAuthor(string $authorId): Book
    {
        return self::create(
            BookIdMother::random(),
            BookImageMother::random(),
            BookTitleMother::random(),
            AuthorIdMother::create($authorId),
            BookPriceMother::random()
        );
    }
}
