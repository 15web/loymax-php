<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Метод апи не найден
 */
final class NotFound extends ApiClientException
{
    public function __construct()
    {
        parent::__construct('Resource not found.', HttpStatusCode::HTTP_NOT_FOUND->value);
    }
}
