<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItem;

use Shared\Domain\Bus\Query\Query;

final class GetItemQuery implements Query
{
    public function __construct(
        private string $id
    ){}

    public function id(): string
    {
        return $this->id;
    }
}
