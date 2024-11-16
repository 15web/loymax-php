<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Request;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Запрос для получения информации о сумме покупок, сумме начисленных и списанных бонусов
 * за указанный период или за все время участия текущего клиента в Программе лояльности
 *
 * @internal
 *
 * @api
 */
final readonly class GetAggregateWithdrawRewardPurchaseRequest
{
    /**
     * @param DateTimeImmutable|null $fromDate Начальная дата выборки
     * @param DateTimeImmutable|null $toDate Конечная дата выборки
     */
    public function __construct(
        #[SerializedName('filter.fromDate')]
        public ?DateTimeImmutable $fromDate,
        #[SerializedName('filter.toDate')]
        public ?DateTimeImmutable $toDate,
    ) {}
}
