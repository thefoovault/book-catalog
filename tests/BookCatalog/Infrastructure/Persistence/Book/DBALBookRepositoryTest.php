<?php

declare(strict_types=1);

namespace Test\BookCatalog\Infrastructure\Persistence\Book;

use BookCatalog\Infrastructure\Persistence\Author\DBALAuthorRepository;
use BookCatalog\Infrastructure\Persistence\Book\DBALBookRepository;
use Test\BookCatalog\Domain\Author\AuthorMother;
use Test\BookCatalog\Domain\Book\BookMother;
use Test\DoctrineTestCase;

class DBALBookRepositoryTest extends DoctrineTestCase
{
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
        $book = BookMother::withAuthor($author->authorId()->value());

        $this->authorRepository->save($author);

        $this->bookRepository->save($book);
    }
}
