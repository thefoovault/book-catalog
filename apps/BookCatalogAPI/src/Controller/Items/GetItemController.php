<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use BookCatalog\Application\GetItem\GetItemQuery;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetItemController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $itemResponse = $this->ask(
            new GetItemQuery($id)
        );

        return $this->createApiResponse($itemResponse);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
