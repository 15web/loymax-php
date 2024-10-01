<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Response\ValidationError;

/**
 * Запрос содержит ошибки валидации
 */
final class InvalidRequest extends ApiClientException
{
    /**
     * @param non-empty-list<ValidationError> $validationErrors
     */
    public function __construct(private readonly array $validationErrors)
    {
        parent::__construct(
            'Ошибка валидации',
            HttpStatusCode::HTTP_BAD_REQUEST->value,
        );
    }

    /**
     * @return non-empty-list<ValidationError>
     */
    public function getErrors(): array
    {
        return $this->validationErrors;
    }
}
