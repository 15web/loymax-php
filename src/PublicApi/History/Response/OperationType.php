<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Тип операции
 */
enum OperationType: string
{
    /**
     * Совершением покупки
     */
    case Purchase = 'PurchaseData';

    /**
     * Начисление бонусов без покупки
     */
    case Reward = 'RewardData';

    /**
     * Списание бонусов без покупки
     */
    case Withdraw = 'WithdrawData';
}
