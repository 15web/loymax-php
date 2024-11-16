<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Request;

use Webmozart\Assert\Assert;

/**
 * Фильтр по внешним идентификаторам торговых точек
 *
 * @internal
 */
final readonly class GetByUidsRequest
{
    /**
     * @param list<non-empty-string> $merchantsUids Фильтр по внешним идентификаторам торговых точек
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        public array $merchantsUids,
        public int $from,
        public int $count,
    ) {
        if ($this->merchantsUids !== []) {
            Assert::allUuid($this->merchantsUids);
        }

        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
