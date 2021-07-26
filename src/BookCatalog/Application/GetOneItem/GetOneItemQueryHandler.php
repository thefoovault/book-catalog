<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use BookCatalog\Domain\Book\BookId;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetOneItemQueryHandler implements QueryHandler
{
    public function __construct(
        private GetOneItem $getItem
    ){}
    public function __invoke(GetOneItemQuery $getItemQuery): ItemResponse
    {
        return $this->getItem->__invoke(new BookId($getItemQuery->id()));
    }
}
