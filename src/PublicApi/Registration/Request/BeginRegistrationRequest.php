<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration\Request;

/**
 * Запрос на регистрацию клиента
 *
 * @internal
 *
 * @api
 */
final readonly class BeginRegistrationRequest
{
    /**
     * @param non-empty-string $login Номер телефона или бонусной карты
     * @param non-empty-string|null $password Пароль для активации карты (при наличии)
     */
    public function __construct(
        public string $login,
        public ?string $password = null,
    ) {}
}
