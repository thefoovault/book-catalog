<?php

declare(strict_types=1);

namespace Test\BookCatalog\Application\GetItems;

use BookCatalog\Application\GetItems\GetItems;
use BookCatalog\Application\GetItems\GetItemsQuery;
use BookCatalog\Application\GetItems\GetItemsQueryHandler;
use BookCatalog\Application\GetItems\ItemResponse;
use BookCatalog\Application\GetItems\ListItemResponse;
use BookCatalog\Domain\Book\BookCollection;
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
        list($expectedListItems, $sampleBookCollection) = $this->createItems();

        $this->bookRepository
            ->expects(self::once())
            ->method('findBy')
            ->willReturn($sampleBookCollection);

        $listItems = $this->getItemsQueryHandler->__invoke(
            new GetItemsQuery(null, null)
        );

        $this->assertInstanceOf(ListItemResponse::class, $listItems);
        $this->assertEquals($expectedListItems, $listItems);
        $this->assertContainsOnlyInstancesOf(ItemResponse::class, $listItems->getIterator());
        $this->assertCount(self::EXPECTED_ITEMS, $listItems->getIterator());
    }

    private function createItems(): array
    {
        $expectedListItems = new ListItemResponse([]);
        $sampleBookCollection = new BookCollection([]);

        for ($i = 0; $i < self::EXPECTED_ITEMS; $i++) {
            $sampleAuthor = AuthorMother::random();
            $sampleBook = BookMother::withAuthor($sampleAuthor);
            $expectedListItem = new ItemResponse(
                $sampleBook->bookId()->value(),
                $sampleBook->bookId()->value(),
                $sampleBook->bookTitle()->value()
            );
            $sampleBookCollection->add($sampleBook);
            $expectedListItems->add($expectedListItem);
        }

        return array($expectedListItems, $sampleBookCollection);
    }
}
