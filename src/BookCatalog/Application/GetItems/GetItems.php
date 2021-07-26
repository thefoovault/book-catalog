<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use BookCatalog\Application\Criteria\Criteria;
use BookCatalog\Domain\Book\BookCollection;
use BookCatalog\Domain\Book\BookRepository;

final class GetItems
{
    public function __construct(
        private BookRepository $bookRepository
    ){}

    public function __invoke(Criteria $criteria): BookCollection
    {
        return $this->bookRepository->findBy($criteria);
    }
}
