<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Информация о бонусах, которые активируются/сгорят в указанный период
 */
final readonly class LifeTimesByPeriod
{
    /**
     * @param float $activationAmount Сумма бонусов к активации
     * @param float $expirationAmount Сумма бонусов к сгоранию
     * @param Period $period Тип периода
     */
    public function __construct(
        public float $activationAmount,
        public float $expirationAmount,
        public Period $period,
    ) {}
}
