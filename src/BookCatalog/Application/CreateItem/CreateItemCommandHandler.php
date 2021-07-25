<?php

declare(strict_types=1);

namespace BookCatalog\Application\CreateItem;

use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookId;
use BookCatalog\Domain\Book\BookImage;
use BookCatalog\Domain\Book\BookPrice;
use BookCatalog\Domain\Book\BookTitle;
use Shared\Domain\Bus\Command\CommandHandler;

final class CreateItemCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateItem $createItem
    ) {}

    public function __invoke(CreateItemCommand $createItemCommand): void
    {
        $book = new Book(
            new BookId($createItemCommand->id()),
            new BookImage($createItemCommand->image()),
            new BookTitle($createItemCommand->title()),
            new AuthorId($createItemCommand->author()),
            new BookPrice($createItemCommand->price())
        );

        $this->createItem->__invoke($book);
    }
}
