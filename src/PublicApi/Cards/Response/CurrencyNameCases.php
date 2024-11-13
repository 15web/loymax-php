<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Варианты написания
 */
final readonly class CurrencyNameCases
{
    /**
     * @param non-empty-string $nominative Именительный падеж
     * @param non-empty-string $genitive Родительный падеж
     * @param non-empty-string $plural Множественное число
     * @param non-empty-string $abbreviation Аббревиатура
     */
    public function __construct(
        public string $nominative,
        public string $genitive,
        public string $plural,
        public string $abbreviation,
    ) {}
}
