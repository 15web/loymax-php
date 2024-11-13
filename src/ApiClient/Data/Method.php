<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Data;

/**
 * HTTP метод запроса
 */
enum Method: string
{
    case GET = 'GET';

    case POST = 'POST';

    case PUT = 'PUT';
}
