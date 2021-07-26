<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use BookCatalog\Application\GetItems\GetItemsQuery;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetItemsController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $offset = $request->query->get('offset');
        $count = $request->query->get('count');
        $items = $this->ask(
            new GetItemsQuery(
                $offset ? (int) $offset : null,
                $count ? (int) $count : null
            )
        );
        return $this->createApiResponse($items);
    }
    protected function exceptions(): array
    {
        return [];
    }
}
