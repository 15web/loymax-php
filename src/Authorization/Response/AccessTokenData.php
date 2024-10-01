<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Токен доступа, а также информация о нем
 */
final readonly class AccessTokenData
{
    /**
     * Токен доступа.
     * Выдается при авторизации или анонимной регистрации и используется при отправке последующих запросов.
     * Имеет небольшое время действия. Используется в паре с refresh token.
     *
     * Токен обновления.
     * Срабатывает, когда время действия токена доступа заканчивается и используется для обновления пары access и refresh токенов.
     * Имеет более продолжительное время действия. Если время действия refresh токена истекло, необходимо заново авторизоваться.
     *
     * @param non-empty-string $accessToken Токен доступа
     * @param non-empty-string $tokenType тип токена доступа
     * @param positive-int $expiresIn время жизни access token в секундах
     * @param non-empty-string $refreshToken Токен обновления
     */
    public function __construct(
        #[SerializedName('access_token')]
        public string $accessToken,
        #[SerializedName('token_type')]
        public string $tokenType,
        #[SerializedName('expires_in')]
        public int $expiresIn,
        #[SerializedName('refresh_token')]
        public string $refreshToken,
    ) {}
}
