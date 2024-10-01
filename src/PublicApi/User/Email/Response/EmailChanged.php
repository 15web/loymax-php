<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email\Response;

/**
 * Результат запроса на смену email
 */
final readonly class EmailChanged
{
    /**
     * @param positive-int $codeLength Количество символов в коде подтверждения
     */
    public function __construct(
        public int $codeLength,
    ) {}
}
