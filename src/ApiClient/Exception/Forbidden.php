<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Доступ запрещен
 */
final class Forbidden extends ApiClientException
{
    public function __construct()
    {
        parent::__construct('Forbidden.', HttpStatusCode::HTTP_FORBIDDEN->value);
    }
}
