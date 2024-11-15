<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\ApiClient\Exception\BadRequest;
use Studio15\Loymax\ApiClient\Exception\DeserializeResponseError;
use Studio15\Loymax\ApiClient\Exception\Forbidden;
use Studio15\Loymax\ApiClient\Exception\InvalidRequest;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\ApiClient\Exception\MethodNotAllowed;
use Studio15\Loymax\ApiClient\Exception\NotFound;
use Studio15\Loymax\ApiClient\Exception\Unauthorized;
use Studio15\Loymax\ApiClient\Exception\UnknownErrorException;
use Studio15\Loymax\ApiClient\Response\Response;
use Studio15\Loymax\ApiClient\Response\ValidationError;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Uid\Uuid;
use Throwable;

/**
 * Клиент для работы HTTP API Loymax
 *
 * @internal
 */
final readonly class ApiClient
{
    /**
     * @param non-empty-string|null $token
     */
    public function __construct(
        private ClientInterface $httpClient,
        private LoggerInterface $logger,
        private ?string $token = null,
    ) {}

    /**
     * @template T of object
     *
     * @param class-string<T> $dataClass Имя класса, в который будет десериализован ответ
     *
     * @return T
     *
     * @throws ApiClientException
     */
    public function sendRequest(RequestInterface $request, string $dataClass = Response::class): object
    {
        $traceId = Uuid::v7();

        if ($this->token !== null) {
            $request = $request->withAddedHeader('authorization', "Bearer {$this->token}");
        }

        $this->logger->info('Loymax SDK Request', [
            'uri' => "{$request->getMethod()} {$request->getUri()}",
            'payload' => (string) $request->getBody(),
            'headers' => $request->getHeaders(),
            'traceId' => (string) $traceId,
        ]);

        try {
            $apiResponse = $this->httpClient->sendRequest(
                request: $request,
            );
        } catch (ClientExceptionInterface $e) {
            $this->logger->error('Loymax SDK Request', [
                'exception' => $e,
                'traceId' => (string) $traceId,
            ]);

            throw new UnknownErrorException(previous: $e);
        }

        $loggerContext = [
            'status' => $apiResponse->getStatusCode(),
            'content' => (string) $apiResponse->getBody(),
            'headers' => $apiResponse->getHeaders(),
            'traceId' => (string) $traceId,
        ];

        if (!$this->responseIsSuccessful($apiResponse)) {
            $exception = $this->resolveException($apiResponse);

            $this->logger->error('Loymax SDK Response', array_merge($loggerContext, [
                'exception' => $exception,
            ]));

            throw $exception;
        }

        $this->logger->info('Loymax SDK Response', $loggerContext);

        try {
            $deserializedResponse = (new CreateSerializer())()->deserialize(
                data: (string) $apiResponse->getBody(),
                type: $dataClass,
                format: JsonEncoder::FORMAT,
            );
        } catch (Throwable $e) {
            throw new DeserializeResponseError(previous: $e);
        }

        if ($deserializedResponse instanceof Response) {
            $this->validateResponse(
                deserializedResponse: $deserializedResponse,
                apiResponse: $apiResponse,
            );
        }

        return $deserializedResponse;
    }

    private function responseIsSuccessful(ResponseInterface $apiResponse): bool
    {
        return $apiResponse->getStatusCode() >= HttpStatusCode::OK->value && $apiResponse->getStatusCode() < HttpStatusCode::MULTIPLE_CHOICES->value;
    }

    private function resolveException(ResponseInterface $response): ApiClientException
    {
        $statusCode = HttpStatusCode::tryFrom($response->getStatusCode());

        return match ($statusCode) {
            HttpStatusCode::BAD_REQUEST => new BadRequest($response),
            HttpStatusCode::UNAUTHORIZED => new Unauthorized($response),
            HttpStatusCode::FORBIDDEN => new Forbidden(),
            HttpStatusCode::NOT_FOUND => new NotFound(),
            HttpStatusCode::METHOD_NOT_ALLOWED => new MethodNotAllowed(),
            default => new UnknownErrorException((string) $response->getBody(), $response->getStatusCode()),
        };
    }

    private function validateResponse(Response $deserializedResponse, ResponseInterface $apiResponse): void
    {
        if ($deserializedResponse->result === null) {
            return;
        }

        if ($deserializedResponse->result->hasErrors()) {
            /** @var non-empty-list<ValidationError> $validationErrors */
            $validationErrors = $deserializedResponse->result->validationErrors;

            throw new InvalidRequest(
                validationErrors: $validationErrors,
            );
        }

        if (!$deserializedResponse->result->isSucceed()) {
            throw new InvalidResponse(
                apiResponse: $apiResponse,
                deserializedResponse: $deserializedResponse,
            );
        }
    }
}
