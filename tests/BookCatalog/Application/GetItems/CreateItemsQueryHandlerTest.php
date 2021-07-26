<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\GetItems;

use BookCatalog\Application\GetItems\GetItems;
use BookCatalog\Application\GetItems\GetItemsQuery;
use BookCatalog\Application\GetItems\GetItemsQueryHandler;
use BookCatalog\Application\GetItems\ItemResponse;
use BookCatalog\Application\GetItems\ListItemResponse;
use BookCatalog\Domain\Book\BookRepository;
use PHPUnit\Framework\TestCase;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookMother;

class CreateItemsQueryHandlerTest extends TestCase
{
    private const EXPECTED_ITEMS = 3;
    private BookRepository $bookRepository;
    private GetItemsQueryHandler $getItemsQueryHandler;

    protected function setUp(): void
    {
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->getItemsQueryHandler = new GetItemsQueryHandler(
            new GetItems($this->bookRepository)
        );
    }

    /** @test */
    public function shouldReturnAValidListOfBooks(): void
    {
        $expectedItems = [];
        $sampleBooks = [];
        for ($i = 0; $i < self::EXPECTED_ITEMS; $i++) {
            $sampleAuthor = AuthorMother::random();
            $sampleBook = BookMother::withAuthor($sampleAuthor->authorId()->value());
            $expectedItems[] = new ItemResponse(
                $sampleBook->bookId()->value(),
                $sampleBook->bookId()->value(),
                $sampleBook->bookTitle()->value()
            );
            $sampleBooks[] = $sampleBook;
        }

        $expectedListItems = new ListItemResponse($expectedItems);

        $this->bookRepository
            ->expects(self::once())
            ->method('findBy')
            ->willReturn($sampleBooks);

        $listItems = $this->getItemsQueryHandler->__invoke(
            new GetItemsQuery(null, null)
        );

        $this->assertInstanceOf(ListItemResponse::class, $listItems);
        $this->assertEquals($expectedListItems, $listItems);
        $this->assertContainsOnlyInstancesOf(ItemResponse::class, $listItems->getIterator());
        $this->assertCount(self::EXPECTED_ITEMS, $listItems->getIterator());
    }
}
