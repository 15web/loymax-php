<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос для подтверждения номера телефона
 *
 * @internal
 */
final readonly class ConfirmPhoneRequest
{
    /**
     * @param non-empty-string $confirmCode Код подтверждения
     * @param non-empty-string $password Пароль пользователя
     */
    public function __construct(
        public string $confirmCode,
        public string $password,
    ) {
        Assert::stringNotEmpty($this->confirmCode);
        Assert::stringNotEmpty($this->password);
    }
}
