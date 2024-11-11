<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Coupons\Response;

/**
 * @api
 * Состояние купона
 */
enum CouponState: string
{
    /**
     * Создан
     */
    case Created = 'Created';

    /**
     * Выдан
     */
    case Issued = 'Issued';

    /**
     * Погашен
     */
    case Used = 'Used';

    /**
     * Отозван
     */
    case Rejected = 'Rejected';

    /**
     * В очереди на гашение
     */
    case QueuedToUse = 'QueuedToUse';

    /**
     * В очереди на выдачу
     */
    case QueuedToIssue = 'QueuedToIssue';

    /**
     * Истек
     */
    case Expired = 'Expired';
}
