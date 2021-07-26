<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetAuthor;

use BookCatalog\Domain\Author\Author;
use BookCatalog\Domain\Author\AuthorId;
use BookCatalog\Domain\Author\AuthorRepository;
use BookCatalog\Domain\Author\Exception\AuthorNotFound;

final class GetAuthor
{
    public function __construct(
        private AuthorRepository $authorRepository
    ){}

    public function __invoke(AuthorId $authorId): Author
    {
        $author = $this->authorRepository->findById($authorId);
        $this->assertAuthorExists($authorId, $author);

        return $author;
    }

    private function assertAuthorExists(AuthorId $authorId, ?Author $author): void
    {
        if (null === $author) {
            throw new AuthorNotFound($authorId);
        }
    }
}
