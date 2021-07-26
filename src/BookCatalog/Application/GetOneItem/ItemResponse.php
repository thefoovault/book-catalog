<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetOneItem;

use BookCatalog\Domain\Book\Book;
use JsonSerializable;
use Shared\Domain\Bus\Query\QueryResponse;

final class ItemResponse implements QueryResponse, JsonSerializable
{
    private const ID = 'id';
    private const IMAGE = 'image';
    private const TITLE = 'title';
    private const AUTHOR = 'author';
    private const PRICE = 'price';

    public function __construct(
        private string $id,
        private string $image,
        private string $title,
        private string $author,
        private float $price
    ){}

    public static function create(array $data): self
    {
        return new self(
            $data['id'],
            $data['image'],
            $data['title'],
            $data['author'],
            (float) $data['price']
        );
    }

    public static function createFromBook(Book $book): self
    {
        return new self(
            $book->bookId()->value(),
            $book->bookImage()->value(),
            $book->bookTitle()->value(),
            $book->bookAuthor()->authorName()->value(),
            $book->bookPrice()->value()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function jsonSerialize(): array
    {
        return [
            self::ID => $this->id(),
            self::IMAGE => $this->image(),
            self::TITLE => $this->title(),
            self::AUTHOR => $this->author(),
            self::PRICE => $this->price()
        ];
    }
}
