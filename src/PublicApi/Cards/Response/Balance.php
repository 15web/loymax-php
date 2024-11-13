<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Информация о балансе карты
 */
final readonly class Balance
{
    /**
     * @param float $amount Сумма бонусов
     * @param non-empty-string $currency Название валюты
     * @param Currency $currencyInfo Информация о валюте
     */
    public function __construct(
        public float $amount,
        public string $currency,
        public Currency $currencyInfo,
    ) {}
}
