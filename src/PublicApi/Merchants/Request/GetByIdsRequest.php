<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Request;

/**
 * Фильтр по внутренним идентификаторам торговых точек
 *
 * @internal
 */
final readonly class GetByIdsRequest
{
    /**
     * @param list<positive-int>|null $merchantsIds Фильтр по внутренним идентификаторам торговых точек
     */
    public function __construct(
        public ?array $merchantsIds = null,
    ) {}
}
