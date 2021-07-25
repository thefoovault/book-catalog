<?php

declare(strict_types=1);

namespace BookCatalog\Application\CreateItem;

use Shared\Domain\Bus\Command\Command;

final class CreateItemCommand implements Command
{
    public function __construct(
        private string $id,
        private string $image,
        private string $title,
        private string $author,
        private float $price
    ) {}

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
}
