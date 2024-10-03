<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Список всех ошибок по всем ответам на вопросы анкеты
 */
final readonly class AnswerErrors
{
    /**
     * @param list<AnswerError> $errors Ошибки
     */
    public function __construct(
        public array $errors = [],
    ) {}
}
