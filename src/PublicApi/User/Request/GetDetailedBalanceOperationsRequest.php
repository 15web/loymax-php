<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * Запрос на получение всех операций активации и сгораниях по конкретному счету клиента
 */
final readonly class GetDetailedBalanceOperationsRequest
{
    public function __construct(
        public ?bool $orderByDateAscending = null,
        public ?DateTimeImmutable $fromDate = null,
        public ?DateTimeImmutable $toDate = null,
        public ?DetailedBalanceOperationType $changeTypes = null,
    ) {
        if ($this->fromDate === null) {
            return;
        }

        if ($this->toDate === null) {
            return;
        }

        Assert::greaterThan($this->toDate, $this->fromDate);
    }
}
