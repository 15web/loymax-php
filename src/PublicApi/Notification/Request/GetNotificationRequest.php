<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос на получение списка оповещений
 *
 * @internal
 */
final readonly class GetNotificationRequest
{
    /**
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        public int $from,
        public int $count,
    ) {
        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
