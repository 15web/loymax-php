<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Client\ClientInterface;

/**
 * Реализация PSR-18 HTTP клиента на примере Guzzle
 *
 * @internal
 */
final readonly class GuzzleHttpClientFactory
{
    /**
     * Таймаут ожидания при попытке подключения к серверу.
     */
    private const CONNECT_TIMEOUT = 10;

    /**
     * Таймаут, описывающий общее время ожидания запроса в секундах.
     */
    private const REQUEST_TIMEOUT = 60;

    /**
     * @param non-empty-string $baseUri
     *
     * @return Client
     */
    public static function create(string $baseUri): ClientInterface
    {
        $stack = HandlerStack::create();

        $stack->remove('http_errors');

        return new Client([
            'handler' => $stack,
            'base_uri' => $baseUri,
            'connect_timeout' => self::CONNECT_TIMEOUT,
            'timeout' => self::REQUEST_TIMEOUT,
            'http_errors' => false,
        ]);
    }
}
