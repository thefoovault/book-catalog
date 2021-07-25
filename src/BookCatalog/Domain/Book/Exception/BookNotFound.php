<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book\Exception;

use BookCatalog\Domain\Book\BookId;
use Shared\Domain\Exception\DomainError;

final class BookNotFound extends DomainError
{
    private BookId $bookId;

    public function __construct(BookId $bookId)
    {
        $this->bookId = $bookId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'book_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Book %s not found',
            $this->bookId->value()
        );
    }
}
