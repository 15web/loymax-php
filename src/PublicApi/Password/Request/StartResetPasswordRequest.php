<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Password\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос на восстановление пароля
 *
 * @internal
 */
final readonly class StartResetPasswordRequest
{
    /**
     * @param non-empty-string $notifierIdentity Значение нотификатора (номер телефона/email)
     */
    public function __construct(
        public string $notifierIdentity,
    ) {
        Assert::stringNotEmpty($this->notifierIdentity);
    }
}
