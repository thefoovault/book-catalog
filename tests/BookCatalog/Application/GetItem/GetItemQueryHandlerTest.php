<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\GetItem;

use BookCatalog\Application\GetItem\GetItem;
use BookCatalog\Application\GetItem\GetItemQuery;
use BookCatalog\Application\GetItem\GetItemQueryHandler;
use BookCatalog\Application\GetItem\GetItemReadModelRepository;
use BookCatalog\Application\GetItem\ItemResponse;
use BookCatalog\Domain\Book\Exception\BookNotFound;
use PHPUnit\Framework\TestCase;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookIdMother;
use Test\BookCatalog\Domain\Book\BookMother;

final class GetItemQueryHandlerTest extends TestCase
{
    private GetItemQueryHandler $getItemQueryHandler;
    private GetItemReadModelRepository $getItemReadModelRepository;

    protected function setUp(): void
    {
        $this->getItemReadModelRepository = $this->createMock(GetItemReadModelRepository::class);
        $this->getItemQueryHandler = new GetItemQueryHandler(
            new GetItem($this->getItemReadModelRepository)
        );
    }

    /** @test */
    public function shouldReturnAValidBook(): void
    {
        $sampleAuthor = AuthorMother::random();
        $sampleBook = BookMother::withAuthor($sampleAuthor->authorId()->value());
        $expectedResponse = new ItemResponse(
            $sampleBook->bookId()->value(),
            $sampleBook->bookImage()->value(),
            $sampleBook->bookTitle()->value(),
            $sampleAuthor->authorName()->value(),
            $sampleBook->bookPrice()->value()
        );

        $this->getItemReadModelRepository
            ->expects(self::once())
            ->method('findBookWithAuthorById')
            ->with($sampleBook->bookId())
            ->willReturn($expectedResponse);

        $itemResponse = $this->getItemQueryHandler->__invoke(
            new GetItemQuery($sampleBook->bookId()->value())
        );

        $this->assertInstanceOf(ItemResponse::class, $itemResponse);
        $this->assertEquals($expectedResponse, $itemResponse);
    }

    /** @test */
    public function shouldThrowBookNotFoundException(): void
    {
        $this->expectException(BookNotFound::class);

        $bookId = BookIdMother::random();
        $this->getItemReadModelRepository
            ->expects(self::once())
            ->method('findBookWithAuthorById')
            ->with($bookId)
            ->willReturn(null);

        $this->getItemQueryHandler->__invoke(
            new GetItemQuery($bookId->value())
        );
    }
}
