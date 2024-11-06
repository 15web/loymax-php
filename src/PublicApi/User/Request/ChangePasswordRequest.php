<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос на обновление пароля клиента
 *
 * @internal
 */
final readonly class ChangePasswordRequest
{
    /**
     * @param non-empty-string $oldPassword Старый пароль
     * @param non-empty-string $newPassword Новый пароль
     */
    public function __construct(
        public string $oldPassword,
        public string $newPassword,
    ) {
        Assert::stringNotEmpty($this->oldPassword);
        Assert::stringNotEmpty($this->newPassword);
        Assert::notEq($this->oldPassword, $this->newPassword);
    }
}
