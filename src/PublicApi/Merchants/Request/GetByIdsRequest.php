<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Request;

use Webmozart\Assert\Assert;

/**
 * Фильтр по внутренним идентификаторам торговых точек
 *
 * @internal
 */
final readonly class GetByIdsRequest
{
    /**
     * @param list<positive-int> $merchantsIds Фильтр по внутренним идентификаторам торговых точек
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        public array $merchantsIds,
        public int $from,
        public int $count,
    ) {
        if ($this->merchantsIds !== []) {
            Assert::allPositiveInteger($this->merchantsIds);
        }

        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
