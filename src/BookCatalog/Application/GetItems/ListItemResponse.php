<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookCollection;
use JsonSerializable;
use Shared\Domain\Aggregate\Collection;
use Shared\Domain\Bus\Query\QueryResponse;

class ListItemResponse extends Collection implements QueryResponse, JsonSerializable
{
    protected function type(): string
    {
        return ItemResponse::class;
    }

    public static function createFromBookCollection(BookCollection $bookCollection): self
    {
        $items = [];
        /** @var Book $book */
        foreach($bookCollection as $book) {
            $items[] = new ItemResponse(
                $book->bookId()->value(),
                $book->bookId()->value(),
                $book->bookTitle()->value()
            );
        }
        return new self(
            $items
        );
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
