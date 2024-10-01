<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Data;

/**
 * Статус ответа на запроса к API
 */
enum HttpStatusCode: int
{
    case HTTP_OK = 200;

    case HTTP_BAD_REQUEST = 400;

    case HTTP_UNAUTHORIZED = 401;

    case HTTP_FORBIDDEN = 403;

    case HTTP_NOT_FOUND = 404;

    case METHOD_NOT_ALLOWED = 405;
}
