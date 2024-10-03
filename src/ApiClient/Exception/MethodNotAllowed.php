<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Неверно указан метод запроса
 */
final class MethodNotAllowed extends ApiClientException
{
    public function __construct()
    {
        parent::__construct('Method Not Allowed.', HttpStatusCode::METHOD_NOT_ALLOWED->value);
    }
}
