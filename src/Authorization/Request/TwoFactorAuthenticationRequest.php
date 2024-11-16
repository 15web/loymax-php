<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Подтверждение запроса на двухфакторную аутентификацию
 *
 * @internal
 *
 * @api
 */
final readonly class TwoFactorAuthenticationRequest
{
    /**
     * @param non-empty-string $grantType Тип аутентификации
     * @param numeric-string $password Код подтверждения
     * @param non-empty-string $twoFactorAuthToken Разовый токен, полученный при запросе токена доступа
     */
    public function __construct(
        #[SerializedName('grant_type')]
        public string $grantType,
        public string $password,
        #[Ignore]
        public string $twoFactorAuthToken,
    ) {}
}
