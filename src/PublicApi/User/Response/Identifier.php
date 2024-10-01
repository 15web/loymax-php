<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Идентификатор пользователя
 */
final readonly class Identifier
{
    /**
     * @param non-empty-string $identifierType
     * @param non-empty-string $value
     */
    public function __construct(
        public string $identifierType,
        public string $value,
    ) {}
}
