<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Запрос для получения токена доступа
 *
 * @internal
 *
 * @api
 */
final readonly class IssueAccessTokenRequest
{
    /**
     * @param non-empty-string $grantType Тип аутентификации
     * @param non-empty-string $username Логин
     * @param non-empty-string|null $password Пароль
     * @param non-empty-string|null $clientIp IP адрес клиента
     */
    public function __construct(
        #[SerializedName('grant_type')]
        public string $grantType,
        public string $username,
        public ?string $password = null,
        #[Ignore]
        public ?string $clientIp = null
    ) {}
}
