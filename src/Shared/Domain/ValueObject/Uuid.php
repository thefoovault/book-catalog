<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }
}
