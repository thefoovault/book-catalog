<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book;

final class Book
{
    public function __construct(
        private BookId $bookId,
        private BookImage $bookImage,
        private BookTitle $bookTitle,
        private BookAuthor $bookAuthor,
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

    public function bookAuthor(): BookAuthor
    {
        return $this->bookAuthor;
    }

    public function bookPrice(): BookPrice
    {
        return $this->bookPrice;
    }
}
