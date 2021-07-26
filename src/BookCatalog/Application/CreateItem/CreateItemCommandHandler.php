<?php

declare(strict_types=1);

namespace BookCatalog\Application\CreateItem;

use BookCatalog\Application\GetAuthor\GetAuthor;
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
        private GetAuthor $getAuthor,
        private CreateItem $createItem
    ) {}

    public function __invoke(CreateItemCommand $createItemCommand): void
    {
        $author = $this->getAuthor->__invoke(
            new AuthorId($createItemCommand->author())
        );

        $book = new Book(
            new BookId($createItemCommand->id()),
            new BookImage($createItemCommand->image()),
            new BookTitle($createItemCommand->title()),
            $author,
            new BookPrice($createItemCommand->price())
        );

        $this->createItem->__invoke($book);
    }
}
