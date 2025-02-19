<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration\Response;

use SensitiveParameter;
use Studio15\Loymax\Authorization\Response\AccessTokenData;

/**
 * @api
 * Результат начала регистрации
 */
final readonly class BeginRegistrationResponse
{
    private const RegistrationBlockedState = 'RegistrationBlocked';

    /**
     * @param string $state Результат начала регистрации
     * @param string|null $errorMessage Текст сообщения об ошибке
     * @param string|null $authToken Токен авторизации для дальнейших действий
     * @param AccessTokenData|null $authResult Результат авторизации
     */
    public function __construct(
        public string $state,
        public ?string $errorMessage,
        #[SensitiveParameter]
        public ?string $authToken,
        public ?AccessTokenData $authResult,
        public ?int $personId,
    ) {}

    public function isRegistrationBlocked(): bool
    {
        return $this->state === self::RegistrationBlockedState;
    }
}
