<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization\Request;

/**
 * Запрос на повторную отправку кода подтверждения
 */
final readonly class SendConfirmationCodeRequest
{
    /**
     * @param non-empty-string $twoFactorAuthToken Разовый токен, полученный при запросе токена доступа
     * @param non-empty-string|null $clientIp IP адрес клиента
     */
    public function __construct(
        public string $twoFactorAuthToken,
        public ?string $clientIp = null
    ) {}
}
