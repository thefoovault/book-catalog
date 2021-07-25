<?php

declare(strict_types=1);

namespace Test\BookCatalog\Infrastructure\Persistence\GetItem;

use BookCatalog\Application\GetItem\ItemResponse;
use BookCatalog\Infrastructure\Persistence\Author\DBALAuthorRepository;
use BookCatalog\Infrastructure\Persistence\Book\DBALBookRepository;
use BookCatalog\Infrastructure\Persistence\GetItem\DBALGetItemReadModelRepository;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookMother;
use Test\DoctrineTestCase;

final class DBALGetItemReadModelRepositoryTest extends DoctrineTestCase
{
    private DBALAuthorRepository $authorRepository;
    private DBALBookRepository $bookRepository;
    private DBALGetItemReadModelRepository $getItemReadModelRepository;

    protected function setUp(): void
    {
        $this->authorRepository = new DBALAuthorRepository($this->connection());
        $this->bookRepository = new DBALBookRepository($this->connection());
        $this->getItemReadModelRepository = new DBALGetItemReadModelRepository($this->connection());
        parent::setUp();
    }

    /** @test */
    public function shouldRetrieveAValidItem(): void
    {
        $sampleAuthor = AuthorMother::random();
        $sampleBook = BookMother::withAuthor($sampleAuthor->authorId()->value());

        $expectedItem = new ItemResponse(
            $sampleBook->bookId()->value(),
            $sampleBook->bookImage()->value(),
            $sampleBook->bookTitle()->value(),
            $sampleAuthor->authorName()->value(),
            $sampleBook->bookPrice()->value()
        );

        $this->authorRepository->save($sampleAuthor);
        $this->bookRepository->save($sampleBook);

        $item = $this->getItemReadModelRepository->findBookWithAuthorById($sampleBook->bookId());

        $this->assertInstanceOf(ItemResponse::class, $item);
        $this->assertEquals($expectedItem, $item);
    }

    /** @test */
    public function shouldReturnNullWhenItemNotFound(): void
    {
        $sampleBook = BookMother::random();

        $item = $this->getItemReadModelRepository->findBookWithAuthorById($sampleBook->bookId());

        $this->assertNull($item);
    }
}
