<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Баланс клиента
 */
final readonly class BalanceInfo
{
    /**
     * @param float $amount Количество бонусов
     * @param non-empty-string $currency Код валюты
     */
    public function __construct(
        public float $amount,
        public string $currency,
    ) {}
}
