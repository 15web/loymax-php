<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Response;

/**
 * @api
 * Статус обработки запроса к API
 */
final readonly class Result
{
    /**
     * @param State $state Статус ответа
     * @param non-empty-string|null $message Сообщение об ошибке
     * @param non-empty-string|null $messageCode Код ошибки
     * @param non-empty-string|null $exception Исключение
     * @param array<ValidationError>|null $validationErrors Список ошибок валидации
     */
    public function __construct(
        public State $state,
        public ?string $message,
        public ?string $messageCode,
        public ?string $exception,
        public ?array $validationErrors,
    ) {}

    public function isSucceed(): bool
    {
        return $this->state === State::SUCCESS;
    }

    public function hasErrors(): bool
    {
        return $this->state === State::VALIDATION_ERROR;
    }
}
