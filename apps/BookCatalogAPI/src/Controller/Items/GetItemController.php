<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetItemController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $item = $request->attributes->get('item');
        return $this->createApiResponse([$item]);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
