<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Request;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Webmozart\Assert\Assert;

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
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        #[SerializedName('filter.fromDate')]
        public ?DateTimeImmutable $fromDate,
        #[SerializedName('filter.toDate')]
        public ?DateTimeImmutable $toDate,
        #[SerializedName('filter.from')]
        public int $from,
        #[SerializedName('filter.count')]
        public int $count,
    ) {
        if ($this->fromDate !== null && $this->toDate !== null) {
            Assert::greaterThan($this->toDate, $this->fromDate);
        }

        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
