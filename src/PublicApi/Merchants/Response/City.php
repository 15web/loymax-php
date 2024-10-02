<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * @api
 * Город
 */
final readonly class City
{
    /**
     * @param positive-int $id Внутренний идентификатор города
     * @param non-empty-string $name Название города
     * @param string|null $prefix Префикс города
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $prefix,
    ) {}
}
