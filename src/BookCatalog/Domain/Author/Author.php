<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Author;

final class Author
{
    public function __construct(
        private AuthorId $authorId,
        private AuthorName $authorName,
    ){}

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function authorName(): AuthorName
    {
        return $this->authorName;
    }
}
