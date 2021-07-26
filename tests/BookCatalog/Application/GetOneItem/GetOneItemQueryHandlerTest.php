<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\GetOneItem;

use BookCatalog\Application\GetOneItem\GetOneItem;
use BookCatalog\Application\GetOneItem\GetOneItemQuery;
use BookCatalog\Application\GetOneItem\GetOneItemQueryHandler;
use BookCatalog\Application\GetOneItem\GetItemReadModelRepository;
use BookCatalog\Application\GetOneItem\ItemResponse;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookRepository;
use BookCatalog\Domain\Book\Exception\BookNotFound;
use PHPUnit\Framework\TestCase;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookIdMother;
use Test\BookCatalog\Domain\Book\BookMother;

final class GetOneItemQueryHandlerTest extends TestCase
{
    private GetOneItemQueryHandler $getItemQueryHandler;
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->getItemQueryHandler = new GetOneItemQueryHandler(
            new GetOneItem($this->bookRepository)
        );
    }

    /** @test */
    public function shouldReturnAValidBook(): void
    {
        list($sampleBook, $expectedResponse) = $this->createItems();

        $this->bookRepository
            ->expects(self::once())
            ->method('findById')
            ->with($sampleBook->bookId())
            ->willReturn($sampleBook);

        $itemResponse = $this->getItemQueryHandler->__invoke(
            new GetOneItemQuery($sampleBook->bookId()->value())
        );

        $this->assertInstanceOf(ItemResponse::class, $itemResponse);
        $this->assertEquals($expectedResponse, $itemResponse);
        $this->assertEquals($expectedResponse->id(), $itemResponse->id());
        $this->assertEquals($expectedResponse->image(), $itemResponse->image());
        $this->assertEquals($expectedResponse->title(), $itemResponse->title());
        $this->assertEquals($expectedResponse->author(), $itemResponse->author());
        $this->assertEquals($expectedResponse->price(), $itemResponse->price());
    }

    /** @test */
    public function shouldThrowBookNotFoundException(): void
    {
        $this->expectException(BookNotFound::class);

        $bookId = BookIdMother::random();
        $this->bookRepository
            ->expects(self::once())
            ->method('findById')
            ->with($bookId)
            ->willReturn(null);

        $this->getItemQueryHandler->__invoke(
            new GetOneItemQuery($bookId->value())
        );
    }

    private function createItems(): array
    {
        $sampleAuthor = AuthorMother::random();
        $sampleBook = BookMother::withAuthor($sampleAuthor);
        $expectedResponse = new ItemResponse(
            $sampleBook->bookId()->value(),
            $sampleBook->bookImage()->value(),
            $sampleBook->bookTitle()->value(),
            $sampleAuthor->authorName()->value(),
            $sampleBook->bookPrice()->value()
        );
        return array($sampleBook, $expectedResponse);
    }
}
