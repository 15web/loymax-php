<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * @api
 * Ответ с агрегированными суммами
 */
final readonly class AggregatedOperations
{
    /**
     * @param list<Purchase> $purchaseAmount Покупки
     * @param list<Withdraw> $withdraws Списания баллов
     * @param list<Reward> $rewards Начисления баллов
     */
    public function __construct(
        public array $purchaseAmount,
        public array $withdraws,
        public array $rewards,
    ) {}
}
