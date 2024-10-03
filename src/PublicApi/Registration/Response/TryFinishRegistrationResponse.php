<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * @api
 * Ответ при попытке завершить регистрацию
 *
 * @see AuthorizationResponse
 */
final readonly class TryFinishRegistrationResponse
{
    /**
     * @param non-empty-string $tokenType Тип токена
     * @param non-empty-string|null $accessToken Авторизационный токен
     * @param non-empty-string|null $refreshToken Токен для обновления
     * @param positive-int|null $expiresIn Срок действия токена
     * @param bool $registrationCompleted Закончена ли регистрация пользователя
     * @param list<UncompletedAction>|null $uncompletedActions Список невыполненных действий клиента
     */
    public function __construct(
        #[SerializedName('token_type')]
        public string $tokenType,
        #[SerializedName('access_token')]
        public ?string $accessToken,
        #[SerializedName('refresh_token')]
        public ?string $refreshToken,
        #[SerializedName('expires_in')]
        public ?int $expiresIn,
        public bool $registrationCompleted,
        public ?array $uncompletedActions,
    ) {}
}
