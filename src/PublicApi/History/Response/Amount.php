<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Сумма
 */
final readonly class Amount
{
    /**
     * @param float $amount Сумма
     * @param Currency $currencyInfo Валюта
     */
    public function __construct(
        public float $amount,
        public Currency $currencyInfo
    ) {}
}
