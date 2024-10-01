<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Request;

use DateTimeImmutable;

/**
 * Запрос для получения списка подтвержденных операций текущего Участника ПЛ
 *
 * @internal
 */
final readonly class GetHistoryRequest
{
    /**
     * @param DateTimeImmutable|null $fromDate Начальная дата выборки
     * @param DateTimeImmutable|null $toDate Конечная дата выборки
     */
    public function __construct(
        public ?DateTimeImmutable $fromDate = null,
        public ?DateTimeImmutable $toDate = null,
    ) {}
}
