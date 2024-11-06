<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Password\Response;

/**
 * @api
 * Результат запроса на восстановление пароля
 */
final readonly class ResetPasswordStarted
{
    /**
     * @param positive-int $codeLength Количество символов в коде подтверждения
     */
    public function __construct(
        public int $codeLength,
    ) {}
}
