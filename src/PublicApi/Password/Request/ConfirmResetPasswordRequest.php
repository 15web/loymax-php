<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Password\Request;

use SensitiveParameter;
use Webmozart\Assert\Assert;

/**
 * Запрос на отправку введенного кода подтверждения для восстановления пароля
 *
 * @internal
 */
final readonly class ConfirmResetPasswordRequest
{
    /**
     * @param non-empty-string $notifierIdentity Значение нотификатора (номер телефона/email)
     * @param non-empty-string $confirmCode Код подтверждения
     * @param non-empty-string $newPassword Новый пароль
     */
    public function __construct(
        public string $notifierIdentity,
        public string $confirmCode,
        #[SensitiveParameter]
        public string $newPassword,
    ) {
        Assert::stringNotEmpty($this->notifierIdentity);
        Assert::stringNotEmpty($this->confirmCode);
        Assert::stringNotEmpty($this->newPassword);
    }
}
