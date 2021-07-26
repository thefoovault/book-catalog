<?php

declare(strict_types=1);

namespace Test\BookCatalog\Infrastructure\Persistence\Book;

use BookCatalog\Application\Criteria\Criteria;
use BookCatalog\Domain\Book\Book;
use BookCatalog\Domain\Book\BookCollection;
use BookCatalog\Infrastructure\Persistence\Author\DBALAuthorRepository;
use BookCatalog\Infrastructure\Persistence\Book\DBALBookRepository;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookMother;
use Test\DoctrineTestCase;

class DBALBookRepositoryTest extends DoctrineTestCase
{
    private const EXPECTED_ITEMS = 3;

    private DBALAuthorRepository $authorRepository;
    private DBALBookRepository $bookRepository;

    protected function setUp(): void
    {
        $this->authorRepository = new DBALAuthorRepository($this->connection());
        $this->bookRepository = new DBALBookRepository($this->connection());
        parent::setUp();
    }

    /** @test */
    public function itShouldSaveABook(): void
    {
        $author = AuthorMother::random();
        $book = BookMother::withAuthor($author);

        $this->authorRepository->save($author);

        $this->bookRepository->save($book);
    }

    /** @test  */
    public function itShouldGetBooks(): void
    {
        for($i = 0; $i < self::EXPECTED_ITEMS; $i++) {
            $sampleBook = BookMother::random();

            $this->authorRepository->save($sampleBook->bookAuthor());
            $this->bookRepository->save($sampleBook);
        }

        $bookCollection = $this->bookRepository->findBy(
            new Criteria(0, self::EXPECTED_ITEMS)
        );

        $this->assertInstanceOf(BookCollection::class, $bookCollection);
        $this->assertCount(self::EXPECTED_ITEMS, $bookCollection);
        $this->assertContainsOnlyInstancesOf(Book::class, $bookCollection->getIterator());
    }
}
