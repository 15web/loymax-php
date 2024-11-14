<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Необходимо авторизоваться
 */
final class Unauthorized extends ApiClientException
{
    public function __construct(ResponseInterface $apiResponse)
    {
        /** @var array{message?: non-empty-string} $data */
        $data = json_decode(
            json: (string) $apiResponse->getBody(),
            associative: true,
        );

        parent::__construct(
            message: $data['message'] ?? 'Unauthorized.',
            code: HttpStatusCode::UNAUTHORIZED->value,
        );
    }
}
