<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email\Response;

/**
 * @api
 * Новый (неподтвержденный) Email
 */
final readonly class NewEmail
{
    /**
     * @param non-empty-string|null $email Новый (неподтвержденный) Email
     */
    public function __construct(
        public ?string $email,
    ) {}
}
