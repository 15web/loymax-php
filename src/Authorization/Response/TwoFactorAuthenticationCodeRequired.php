<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Response;

/**
 * Разовый токен, полученный при запросе токена доступа
 * Ответ формируется при включенной двухфакторной аутентификации в Личном кабинете Loymax
 */
final readonly class TwoFactorAuthenticationCodeRequired
{
    public function __construct(
        public string $twoFactorAuthToken,
    ) {}
}
