<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use BookCatalog\Application\CreateItem\CreateItemCommand;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateItemController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $parameters = $this->getPayload($request);

        $id = Uuid::random()->value();

        $this->dispatch(
            new CreateItemCommand(
                $id,
                $parameters['image'],
                $parameters['title'],
                $parameters['author'],
                $parameters['price']
            )
        );

        return $this->createApiResponse([$id], Response::HTTP_CREATED);
    }
    protected function exceptions(): array
    {
        return [];
    }
}
