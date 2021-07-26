<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Controller;

use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\each;

abstract class ApiController extends Controller
{
    const CONTENT_TYPE = 'application/json';

    public function __construct(
        protected QueryBus $queryBus,
        protected CommandBus $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
        parent::__construct($this->queryBus, $this->commandBus);
        each(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    protected function createApiResponse(mixed $data, int $status_code = Response::HTTP_OK): Response
    {
        return new Response(
            json_encode($data),
            $status_code,
            [
                'Content-Type' => self::CONTENT_TYPE,
            ]
        );
    }

    abstract protected function exceptions(): array;
}
