<?php

declare(strict_types=1);

namespace BookCatalog\Application\Criteria;

class Criteria
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 10;

    public function __construct(
        private ?int $offset,
        private ?int $limit
    ){
        $this->offset = $offset ?? self::DEFAULT_OFFSET;
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
