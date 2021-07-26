<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Author\Exception;

use BookCatalog\Domain\Author\AuthorId;
use Shared\Domain\Exception\DomainError;

final class AuthorNotFound extends DomainError
{
    private AuthorId $authorId;

    public function __construct(AuthorId $authorId)
    {
        $this->authorId = $authorId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'book_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Author %s not found',
            $this->authorId->value()
        );
    }
}
