<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

/**
 * Запрос на получение информации о клиенте
 *
 * @internal
 */
final readonly class GetUserRequest
{
    /**
     * @param list<GetUserPayload|non-empty-string> $payload Список логических имен атрибутов, информацию о которых необходимо получить
     */
    public function __construct(
        public array $payload,
    ) {}
}
