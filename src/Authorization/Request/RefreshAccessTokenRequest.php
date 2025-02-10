<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Запрос на перевыпуск токена доступа
 *
 * @internal
 *
 * @api
 */
final readonly class RefreshAccessTokenRequest
{
    /**
     * @param non-empty-string $grantType Тип аутентификации
     * @param non-empty-string $accessToken Устаревший токен доступа
     * @param non-empty-string $refreshToken Токен обновления
     */
    public function __construct(
        #[SerializedName('grant_type')]
        public string $grantType,
        #[Ignore]
        public string $accessToken,
        #[SerializedName('refresh_token')]
        public string $refreshToken,
    ) {}
}
