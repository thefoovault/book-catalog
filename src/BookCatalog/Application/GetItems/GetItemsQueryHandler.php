<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use BookCatalog\Application\Criteria\Criteria;
use BookCatalog\Domain\Book\Book;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetItemsQueryHandler implements QueryHandler
{
    public function __construct(
        private GetItems $getItems
    ){}

    public function __invoke(GetItemsQuery $getItemsQuery): ListItemResponse
    {
        $books = $this->getItems->__invoke(
            new Criteria(
                $getItemsQuery->offset(),
                $getItemsQuery->count()
            )
        );

        return ListItemResponse::createFromBookCollection($books);
    }
}
