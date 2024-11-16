<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос на изменение email
 *
 * @internal
 */
final readonly class ChangeEmailRequest
{
    /**
     * @param non-empty-string $email Новый Email клиента
     */
    public function __construct(
        public string $email,
    ) {
        Assert::email($this->email);
    }
}
