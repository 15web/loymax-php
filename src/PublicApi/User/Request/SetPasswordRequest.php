<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

use SensitiveParameter;
use Webmozart\Assert\Assert;

/**
 * Запрос на установку пароля
 *
 * @internal
 */
final readonly class SetPasswordRequest
{
    /**
     * @param non-empty-string $password Пароль
     */
    public function __construct(
        #[SensitiveParameter]
        public string $password,
    ) {
        Assert::stringNotEmpty($this->password);
    }
}
