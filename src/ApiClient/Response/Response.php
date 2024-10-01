<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Response;

/**
 * Ответ от методов публичного API
 *
 * @internal
 */
final readonly class Response
{
    /**
     * @param mixed $data Данные обработки запроса
     * @param Result|null $result Результат обработки запроса
     */
    public function __construct(
        public mixed $data,
        public ?Result $result,
    ) {}
}
