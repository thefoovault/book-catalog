<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->assertIsValidUuid($value);
        parent::__construct($value);
    }

    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    private function assertIsValidUuid(string $value): void
    {
        RamseyUuid::isValid($value);
    }
}
