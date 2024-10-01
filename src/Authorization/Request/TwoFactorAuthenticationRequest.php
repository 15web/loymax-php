<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

/**
 * Подтверждение запроса на двухфакторную аутентификацию
 *
 * @internal
 */
final readonly class TwoFactorAuthenticationRequest
{
    /**
     * @param non-empty-string $twoFactorAuthToken Разовый токен, полученный при запросе токена доступа
     * @param numeric-string $code Код подтверждения
     */
    public function __construct(
        public string $twoFactorAuthToken,
        public string $code,
    ) {}
}
