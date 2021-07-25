<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetItemsController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        return $this->createApiResponse([]);
    }
    protected function exceptions(): array
    {
        return [];
    }
}
