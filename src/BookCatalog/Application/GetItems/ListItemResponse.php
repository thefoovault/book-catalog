<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use JsonSerializable;
use Shared\Domain\Aggregate\Collection;
use Shared\Domain\Bus\Query\QueryResponse;

class ListItemResponse extends Collection implements QueryResponse, JsonSerializable
{
    protected function type(): string
    {
        return ItemResponse::class;
    }

    public function jsonSerialize(): array
    {
        $elements = [];

        foreach ($this->getIterator() as $element) {
            $elements[] = $element;
        }

        return $elements;
    }
}
