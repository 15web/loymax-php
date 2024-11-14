<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Data;

/**
 * Статус ответа на запрос к API
 */
enum HttpStatusCode: int
{
    case OK = 200;

    case MULTIPLE_CHOICES = 300;

    case BAD_REQUEST = 400;

    case UNAUTHORIZED = 401;

    case FORBIDDEN = 403;

    case NOT_FOUND = 404;

    case METHOD_NOT_ALLOWED = 405;
}
