<?php

declare(strict_types=1);

namespace Test\BookCatalog\Domain\Book;

use BookCatalog\Domain\Author\Author;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\BookImage;
use BookCatalog\Domain\Book\BookPrice;
use BookCatalog\Domain\Book\BookTitle;
use Test\BookCatalog\Domain\Author\AuthorMother;

final class BookMother
{
    public static function create(
        BookId $bookId,
        BookImage $bookImage,
        BookTitle $bookTitle,
        Author $bookAuthor,
        BookPrice $bookPrice
    ): Book
    {
        return new Book($bookId, $bookImage, $bookTitle, $bookAuthor, $bookPrice);
    }

    public static function random(): Book
    {
        return self::create(
            BookIdMother::random(),
            BookImageMother::random(),
            BookTitleMother::random(),
            AuthorMother::random(),
            BookPriceMother::random()
        );
    }

    public static function withAuthor(Author $author): Book
    {
        return self::create(
            BookIdMother::random(),
            BookImageMother::random(),
            BookTitleMother::random(),
            $author,
            BookPriceMother::random()
        );
    }
}
