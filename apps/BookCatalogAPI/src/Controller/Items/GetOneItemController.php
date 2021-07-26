<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use BookCatalog\Application\GetOneItem\GetOneItemQuery;
use BookCatalog\Domain\Book\Exception\BookNotFound;
use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOneItemController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $itemResponse = $this->ask(
            new GetOneItemQuery($id)
        );

        return $this->createApiResponse($itemResponse);
    }

    protected function exceptions(): array
    {
        return [
            BookNotFound::class => Response::HTTP_NOT_FOUND,
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
