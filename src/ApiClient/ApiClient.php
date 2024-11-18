<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Data\Method;
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
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Uid\Uuid;
use Throwable;

/**
 * Клиент для работы HTTP API Loymax
 *
 * @internal
 */
final readonly class ApiClient
{
    private Serializer $serializer;

    /**
     * @param non-empty-string|null $token
     */
    public function __construct(
        private ClientInterface $httpClient,
        private LoggerInterface $logger,
        private ?string $token = null,
    ) {
        $this->serializer = (new CreateSerializer())();
    }

    /**
     * @template T of object
     *
     * @param non-empty-string $uri
     * @param list<object>|object|null $body
     * @param array<array-key, array<array-key, string>|string> $headers
     * @param class-string<T> $dataClass Имя класса, в который будет десериализован ответ
     *
     * @return T
     *
     * @throws ApiClientException
     */
    public function sendRequest(
        Method $method,
        string $uri,
        ?object $parameters = null,
        null|array|object $body = null,
        array $headers = [],
        string $dataClass = Response::class,
    ): object {
        $traceId = (string) Uuid::v7();

        $normalizedParameters = [];
        if ($parameters !== null) {
            /** @var array<array-key, mixed> $normalizedParameters */
            $normalizedParameters = $this->serializer->normalize(
                data: $parameters,
                format: JsonEncoder::FORMAT,
                context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
            );
        }

        $normalizedBody = [];
        if ($body !== null) {
            /** @var array<array-key, mixed> $normalizedBody */
            $normalizedBody = $this->serializer->normalize(
                data: $body,
                format: JsonEncoder::FORMAT,
                context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
            );
        }

        if ($this->token !== null) {
            $headers['Authorization'] = "Bearer {$this->token}";
        }

        $request = (new CreateRequest())(
            method: $method,
            uri: $uri,
            parameters: $normalizedParameters,
            body: $normalizedBody,
            headers: $headers,
        );

        $this->logger->info('Loymax SDK Request', [
            'uri' => "{$request->getMethod()} {$request->getUri()}",
            'payload' => (string) $request->getBody(),
            'headers' => $request->getHeaders(),
            'traceId' => $traceId,
        ]);

        try {
            $apiResponse = $this->httpClient->sendRequest(
                request: $request,
            );
        } catch (ClientExceptionInterface $e) {
            $this->logger->error('Loymax SDK Request', [
                'exception' => $e,
                'traceId' => $traceId,
            ]);

            throw new UnknownErrorException(previous: $e);
        }

        $loggerContext = [
            'status' => $apiResponse->getStatusCode(),
            'content' => (string) $apiResponse->getBody(),
            'headers' => $apiResponse->getHeaders(),
            'traceId' => $traceId,
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
            $deserializedResponse = $this->serializer->deserialize(
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
