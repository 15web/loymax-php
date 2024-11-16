<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Studio15\Loymax\ApiClient\Data\ContentType;
use Studio15\Loymax\ApiClient\Data\Method;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Подготовка запроса
 *
 * @internal
 */
final readonly class CreateRequest
{
    /**
     * @param non-empty-string $uri
     * @param array<array-key, mixed> $parameters
     * @param array<array-key, mixed> $body
     * @param array<array-key, array<array-key, string>|string> $headers
     */
    public function __invoke(
        Method $method,
        string $uri,
        array $parameters = [],
        array $body = [],
        array $headers = [],
    ): RequestInterface {
        $headers = array_change_key_case($headers);

        $contentType = $this->getContentType($headers);
        $headers['Content-Type'] = $contentType->value;

        $encodedBody = $this->encodeBody(
            contentType: $contentType,
            body: $body,
        );

        if ($parameters !== []) {
            $uri .= \sprintf('?%s', http_build_query($parameters));
        }

        return new Request(
            method: $method->value,
            uri: $uri,
            headers: $headers,
            body: $encodedBody,
        );
    }

    /**
     * @param array<array-key, mixed> $headers
     */
    private function getContentType(array $headers): ContentType
    {
        if (!\array_key_exists('content-type', $headers)) {
            return ContentType::JSON;
        }

        /** @var non-empty-string $contentType */
        $contentType = $headers['content-type'];

        return ContentType::from($contentType);
    }

    /**
     * @param array<array-key, mixed> $body
     */
    private function encodeBody(ContentType $contentType, array $body): string
    {
        if ($body === []) {
            return '{}';
        }

        $serializer = new CreateSerializer();

        return match ($contentType) {
            ContentType::JSON => ($serializer)()->encode(
                data: $body,
                format: JsonEncoder::FORMAT,
            ),
            ContentType::URLENCODED => http_build_query($body),
        };
    }
}
