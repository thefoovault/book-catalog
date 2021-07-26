<?php

declare(strict_types=1);

namespace BookCatalog\Domain\Book;

use Shared\Domain\Aggregate\Collection;

final class BookCollection extends Collection
{
    protected function type(): string
    {
        return Book::class;
    }
}
