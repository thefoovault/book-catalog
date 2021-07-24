<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CreateItemController extends ApiController
{
    public function __invoke(): Response
    {
        return $this->createApiResponse(['test']);
    }
    protected function exceptions(): array
    {
        return [];
    }
}
