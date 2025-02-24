<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

use DateTimeImmutable;

/**
 * @api
 * OAuth аккаунт
 */
final readonly class SocialIdentifier
{
    /**
     * @param non-empty-string $provider
     * @param non-empty-string $userId
     */
    public function __construct(
        public string $provider,
        public string $userId,
        public DateTimeImmutable $creationDate,
    ) {}
}
