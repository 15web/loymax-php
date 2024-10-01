<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Request;

/**
 * Фильтр по внешним идентификаторам торговых точек
 *
 * @internal
 */
final readonly class GetByUidsRequest
{
    /**
     * @param list<non-empty-string>|null $merchantsUids Фильтр по внешним идентификаторам торговых точек
     */
    public function __construct(
        public ?array $merchantsUids = null,
    ) {}
}
