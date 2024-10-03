<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Необходимо авторизоваться
 */
final class Unauthorized extends ApiClientException
{
    public function __construct()
    {
        parent::__construct('Unauthorized.', HttpStatusCode::HTTP_UNAUTHORIZED->value);
    }
}
