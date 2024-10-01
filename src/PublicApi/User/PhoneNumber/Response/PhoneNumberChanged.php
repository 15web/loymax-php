<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber\Response;

/**
 * Результат запроса на смену номера телефона
 */
final readonly class PhoneNumberChanged
{
    /**
     * @param positive-int $codeLength Количество символов в коде подтверждения
     */
    public function __construct(
        public int $codeLength,
    ) {}
}
