<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Список логинов пользователя
 */
final readonly class Logins
{
    /**
     * @param list<Identifier> $identifiers Идентификаторы пользователя
     */
    public function __construct(
        public array $identifiers
    ) {}
}
