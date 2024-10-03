<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

use DateTimeImmutable;

/**
 * @api
 * Информация о бонусах, которые будут активированы или сгорят в течение недели
 */
final readonly class LifeTimesByTime
{
    /**
     * @param float $amount Сумма бонусов (может быть отрицательная для сгорающих бонусов)
     * @param DateTimeImmutable $date Дата активации/сгорания бонусов
     */
    public function __construct(
        public float $amount,
        public DateTimeImmutable $date,
    ) {}
}
