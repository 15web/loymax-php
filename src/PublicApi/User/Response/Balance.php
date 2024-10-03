<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Информация о балансе клиента
 */
final readonly class Balance
{
    /**
     * @param Currency $currency Информации о валюте
     * @param float $balance Баланс счета клиента
     * @param float $notActivated Неактивированные бонусы
     * @param float $accumulated Бонусов получено
     * @param float $paid Бонусов потрачено
     */
    public function __construct(
        public Currency $currency,
        public float $balance,
        public float $notActivated,
        public float $accumulated,
        public float $paid,
    ) {}
}
