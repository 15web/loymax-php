<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Внешний ID подписки
 */
enum SubscriptionExternalId: string
{
    /**
     * Информация о начисленной скидке
     */
    case DiscountOperation = 'DiscountOperation';

    /**
     * Информация об операции оплаты
     */
    case PaymentOperation = 'PaymentOperation';

    /**
     * Информация о пополнении счета
     */
    case DepositOperation = 'DepositOperation';

    /**
     * Информация об акциях
     */
    case CommunicationOffer = 'CommunicationOffer';

    /**
     * Системная информация
     */
    case System = 'System';

    /**
     * Рассылки
     */
    case Advertisement = 'Advertisement';

    /**
     * Информация об операции возврата
     */
    case RefundOperation = 'RefundOperation';
}
