<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use Shared\Domain\Bus\Query\Query;

final class GetItemsQuery implements Query
{
    public function __construct(
        private ?int $offset,
        private ?int $count
    ){}

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function count(): ?int
    {
        return $this->count;
    }
}
