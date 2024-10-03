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
     * @param float $amount Количество бонусов
     * @param Currency $currencyInfo Подробная информация о валюте бонусов
     */
    public function __construct(
        public float $amount,
        public Currency $currencyInfo,
    ) {}
}
