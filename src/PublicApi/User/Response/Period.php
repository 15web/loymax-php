<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Тип периода
 */
enum Period: string
{
    /**
     * От недели до месяца
     */
    case FROM_WEEK_TO_MONTH = 'FromWeekToMonth';

    /**
     * От месяца до года
     */
    case FROM_MONTH_TO_YEAR = 'FromMonthToYear';

    /**
     * От года
     */
    case FROM_YEAR = 'FromYear';
}
