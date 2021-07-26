<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\CreateItem;

use BookCatalog\Application\CreateItem\CreateItem;
use BookCatalog\Application\CreateItem\CreateItemCommand;
use BookCatalog\Application\CreateItem\CreateItemCommandHandler;
use BookCatalog\Application\GetAuthor\GetAuthor;
use BookCatalog\Domain\Author\AuthorRepository;
use BookCatalog\Domain\Author\Exception\AuthorNotFound;
use BookCatalog\Domain\Book\BookRepository;
use PHPUnit\Framework\TestCase;
use Test\BookCatalog\Domain\Book\BookMother;

final class CreateItemCommandHandlerTest extends TestCase
{
    private CreateItemCommandHandler $createItemCommandHandler;
    private BookRepository $bookRepository;
    private AuthorRepository $authorRepository;

    public function setUp(): void
    {
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->authorRepository = $this->createMock(AuthorRepository::class);
        $this->createItemCommandHandler = new CreateItemCommandHandler(
            new GetAuthor($this->authorRepository),
            new CreateItem($this->bookRepository)
        );
    }

    public function tearDown(): void
    {
        unset(
            $this->bookRepository,
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

        $this->authorRepository
            ->expects(self::once())
            ->method('findById')
            ->with($book->bookAuthor()->authorId())
            ->willReturn($book->bookAuthor());

        $this->createItemCommandHandler->__invoke(
            new CreateItemCommand(
                $book->bookId()->value(),
                $book->bookImage()->value(),
                $book->bookTitle()->value(),
                $book->bookAuthor()->authorId()->value(),
                $book->bookPrice()->value(),
            )
        );
    }

    /** @test */
    public function shouldThrowException(): void
    {
        $this->expectException(AuthorNotFound::class);

        $book = BookMother::random();

        $this->bookRepository
            ->expects(self::never())
            ->method('save')
            ->with($book);

        $this->authorRepository
            ->expects(self::once())
            ->method('findById')
            ->with($book->bookAuthor()->authorId())
            ->willReturn(null);

        $this->createItemCommandHandler->__invoke(
            new CreateItemCommand(
                $book->bookId()->value(),
                $book->bookImage()->value(),
                $book->bookTitle()->value(),
                $book->bookAuthor()->authorId()->value(),
                $book->bookPrice()->value(),
            )
        );
    }
}
