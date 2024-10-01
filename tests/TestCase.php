<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Studio15\Loymax\Loymax;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param list<Response> $mockResponseList
     */
    protected function createLoymaxClient(array $mockResponseList = []): Loymax
    {
        $client = new Client([
            'handler' => HandlerStack::create(
                new MockHandler($mockResponseList),
            ),
        ]);

        return new Loymax(
            httpClient: $client,
        );
    }
}
