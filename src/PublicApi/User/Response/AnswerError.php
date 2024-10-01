<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Список ошибок по конкретному ответу на вопрос анкеты
 */
final readonly class AnswerError
{
    /**
     * @param non-empty-string $idQuestion Внутренний идентификатор вопроса
     * @param array<non-empty-string> $errors Список ошибок
     */
    public function __construct(
        public string $idQuestion,
        public array $errors,
    ) {}
}
