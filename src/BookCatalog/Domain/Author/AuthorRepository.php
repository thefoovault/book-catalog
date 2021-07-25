<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Author;

interface AuthorRepository
{
    public function save(Author $author): void;
}
