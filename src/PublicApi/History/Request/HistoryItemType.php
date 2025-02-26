<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Request;

/**
 * Тип события в истории покупок
 */
enum HistoryItemType: string
{
    /**
     * Все события
     */
    case ALL = 'All';

    /**
     * События, связанные с покупкой
     */
    case PURCHASE = 'Purchase';

    /**
     * События, связанные с начислением бонусов без покупки
     */
    case REWARD = 'RewardData';

    /**
     * События, связанные со списанием бонусов без покупки
     */
    case WITHDRAW = 'WithdrawData';
}
