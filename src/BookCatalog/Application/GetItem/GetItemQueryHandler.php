<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItem;

use BookCatalog\Domain\Book\BookId;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetItemQueryHandler implements QueryHandler
{
    public function __construct(
        private GetItem $getItem
    ){}
    public function __invoke(GetItemQuery $getItemQuery): ItemResponse
    {
        return $this->getItem->__invoke(new BookId($getItemQuery->id()));
    }
}
