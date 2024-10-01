<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

/**
 * Список логических имен атрибутов, информацию о которых необходимо получить
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User
 */
enum GetUserPayload: string
{
    /**
     * Получить информацию о состоянии клиента
     */
    case State = 'State';

    /**
     * Получить информацию о картах клиента
     */
    case Cards = 'Cards';

    /**
     * Получить информацию о балансе клиента
     */
    case BalanceShortInfo = 'BalanceShortInfo';

    /**
     * Получить расширенную информацию о балансе клиента в разрезе виртуальных валют
     */
    case BalanceDetailedInfo = 'BalanceDetailedInfo';

    /**
     * Получить информацию о подтвержденной и неподтвержденной электронной почте клиента
     */
    case EmailDetailedInfo = 'EmailDetailedInfo';
}
