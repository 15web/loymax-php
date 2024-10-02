<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Throwable;

/**
 * @api
 * Ошибка приложения
 */
final class UnknownErrorException extends ApiClientException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
