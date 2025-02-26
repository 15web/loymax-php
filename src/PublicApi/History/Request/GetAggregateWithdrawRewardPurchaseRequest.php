<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Request;

use DateTimeImmutable;

/**
 * Запрос для получения информации о сумме покупок, сумме начисленных и списанных бонусов
 * за указанный период или за все время участия текущего клиента в Программе лояльности
 *
 * @internal
 */
final readonly class GetAggregateWithdrawRewardPurchaseRequest
{
    /**
     * @param DateTimeImmutable|null $fromDate Начальная дата выборки
     * @param DateTimeImmutable|null $toDate Конечная дата выборки
     * @param HistoryItemType|null $historyItemType Тип события в истории покупок
     */
    public function __construct(
        public ?DateTimeImmutable $fromDate = null,
        public ?DateTimeImmutable $toDate = null,
        public ?HistoryItemType $historyItemType = null,
    ) {}
}
