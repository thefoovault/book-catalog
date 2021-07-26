<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

final class InvalidUuid extends DomainError
{
    private string $uuid
    ;
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
        parent::__construct();
    }

    public function errorMessage(): string
    {
        return 'invalid_uuid';
    }

    public function errorCode(): string
    {
        return sprintf(
            'The identifier %s is invalid',
            $this->uuid
        );
    }
}
