<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book;

use BookCatalog\Domain\Author\AuthorId;
use Shared\Domain\Aggregate\AggregateRoot;

final class Book extends AggregateRoot
{
    public function __construct(
        private BookId $bookId,
        private BookImage $bookImage,
        private BookTitle $bookTitle,
        private AuthorId $bookAuthor,
        private BookPrice $bookPrice
    ){}

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookImage(): BookImage
    {
        return $this->bookImage;
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }

    public function bookAuthor(): AuthorId
    {
        return $this->bookAuthor;
    }

    public function bookPrice(): BookPrice
    {
        return $this->bookPrice;
    }
}
