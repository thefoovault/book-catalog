<?php

declare(strict_types=1);

namespace BookCatalogAPI\Controller\Items;

use BookCatalog\Application\CreateItem\CreateItemCommand;
use BookCatalog\Domain\Author\Exception\AuthorNotFound;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateItemController extends ApiController
{
    const API_URL = 'api/%s/items/%s';

    public function __invoke(Request $request): Response
    {
        $parameters = $this->getPayload($request);
        $version = $request->attributes->get('version');

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

        return $this->createApiResponse([$this->createUrl($id, $version)], Response::HTTP_CREATED);
    }
    protected function exceptions(): array
    {
        return [
            AuthorNotFound::class => Response::HTTP_NOT_FOUND
        ];
    }

    private function createUrl(string $id, string $version): string
    {
        return sprintf(
            self::API_URL,
            $version,
            $id
        );
    }
}
