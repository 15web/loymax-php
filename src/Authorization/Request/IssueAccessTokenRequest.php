<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

use SensitiveParameter;

/**
 * Запрос для получения токена доступа
 *
 * @internal
 */
final readonly class IssueAccessTokenRequest
{
    /**
     * @param non-empty-string $username Логин
     * @param non-empty-string|null $password Пароль
     * @param non-empty-string|null $clientIp IP адрес клиента
     */
    public function __construct(
        public string $username,
        #[SensitiveParameter]
        public ?string $password = null,
        public ?string $clientIp = null,
    ) {}
}
