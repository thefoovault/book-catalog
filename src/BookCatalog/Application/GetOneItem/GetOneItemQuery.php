<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use Shared\Domain\Bus\Query\Query;

final class GetOneItemQuery implements Query
{
    public function __construct(
        private string $id
    ){}

    public function id(): string
    {
        return $this->id;
    }
}
