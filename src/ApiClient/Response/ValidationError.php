<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Response;

/**
 * Ошибка валидации
 */
final readonly class ValidationError
{
    /**
     * @param non-empty-string $field Наименование поля
     * @param array<non-empty-string> $errorMessages Список ошибок
     */
    public function __construct(
        public string $field,
        public array $errorMessages,
    ) {}
}
