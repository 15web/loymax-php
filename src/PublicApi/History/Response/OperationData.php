<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Данные об операции
 */
final readonly class OperationData
{
    /**
     * @param Amount $amount Основная сумма операции
     * @param list<Withdraw> $withdraws Списания в рамках операции
     * @param list<Reward> $rewards Начисления в рамках операции
     * @param list<ChequeItem> $chequeItems Позиции чека
     * @param bool $isRefund Признак возврата
     */
    public function __construct(
        public Amount $amount,
        public array $withdraws = [],
        public array $rewards = [],
        public array $chequeItems = [],
        public bool $isRefund = false,
    ) {}
}
