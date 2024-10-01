<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Детализированный баланс
 */
final readonly class DetailedBalance
{
    /**
     * @param Currency $currency Информация о валюте
     * @param float $amount Общая сумма
     * @param float $notActivatedAmount Сумма неактивированных бонусов
     * @param bool $accountIsBlocked Признак блокировки счета
     * @param list<LifeTimesByTime> $lifeTimesByTime Информация о бонусах, которые будут активированы или сгорят в течение недели
     * @param list<LifeTimesByPeriod> $lifeTimesByPeriod Информация о бонусах, которые активируются/сгорят в указанный период
     */
    public function __construct(
        public Currency $currency,
        public float $amount,
        public float $notActivatedAmount,
        public bool $accountIsBlocked,
        public array $lifeTimesByTime,
        public array $lifeTimesByPeriod,
    ) {}
}
