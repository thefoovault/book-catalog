<?php

declare(strict_types=1);

namespace BookCatalog\Application\GetItems;

use JsonSerializable;
use Shared\Domain\Bus\Query\QueryResponse;

class ItemResponse implements QueryResponse, JsonSerializable
{
    private const ID = 'id';
    private const LINK = 'link';
    private const TITLE = 'title';

    public function __construct(
        private string $id,
        private string $link,
        private string $title
    ){}

    public function id(): string
    {
        return $this->id;
    }

    public function link(): string
    {
        return $this->link;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function jsonSerialize(): array
    {
        return [
            self::ID => $this->id(),
            self::LINK => $this->link(),
            self::TITLE => $this->title()
        ];
    }
}
