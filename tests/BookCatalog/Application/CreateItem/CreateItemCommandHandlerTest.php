<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\CreateItem;

use BookCatalog\Application\CreateItem\CreateItem;
use BookCatalog\Application\CreateItem\CreateItemCommand;
use BookCatalog\Application\CreateItem\CreateItemCommandHandler;
use BookCatalog\Domain\Book\BookRepository;
use PHPUnit\Framework\TestCase;
use Test\BookCatalog\Domain\Book\BookMother;

final class CreateItemCommandHandlerTest extends TestCase
{
    private CreateItemCommandHandler $createItemCommandHandler;
    private CreateItem $createItem;
    private BookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->createItem =  new CreateItem($this->bookRepository);
        $this->createItemCommandHandler = new CreateItemCommandHandler($this->createItem);
    }

    public function tearDown(): void
    {
        unset(
            $this->bookRepository,
            $this->createItem,
            $this->createItemCommandHandler
        );
    }

    /** @test */
    public function shouldCreateABook(): void
    {
        $book = BookMother::random();

        $this->bookRepository
            ->expects(self::once())
            ->method('save')
            ->with($book);

        $this->createItemCommandHandler->__invoke(
            new CreateItemCommand(
                $book->bookId()->value(),
                $book->bookImage()->value(),
                $book->bookTitle()->value(),
                $book->bookAuthor()->value(),
                $book->bookPrice()->value(),
            )
        );
    }

    private function getCommandHandler(): CreateItemCommandHandler
    {
        return new CreateItemCommandHandler($this->createItem);
    }
}
