<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * @api
 * Баланс клиента
 */
final readonly class BalanceShortInfo
{
    public function __construct(
        public BalanceInfo $balance,
        public BalanceInfo $notActivated,
        public BalanceInfo $accumulated,
        public BalanceInfo $paid,
    ) {}
}
