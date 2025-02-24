<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Список логинов пользователя
 */
final readonly class Logins
{
    /**
     * @param list<Identifier> $identifiers Идентификаторы пользователя
     * @param list<SocialIdentifier> $socialIdentifiers OAuth аккаунты
     */
    public function __construct(
        public array $identifiers,
        public array $socialIdentifiers,
    ) {}
}
