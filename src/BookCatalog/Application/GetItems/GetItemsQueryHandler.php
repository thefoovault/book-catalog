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

        $items = new ListItemResponse([]);

        /** @var Book $book */
        foreach($books as $book) {
            $item = new ItemResponse(
                $book->bookId()->value(),
                $book->bookId()->value(),
                $book->bookTitle()->value()
            );
            $items->add($item);
        }

        return $items;
    }
}
