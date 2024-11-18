<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Request;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Webmozart\Assert\Assert;

/**
 * Запрос на получение информации о таргетированном контенте
 *
 * @internal
 *
 * @api
 */
final readonly class GetOfferRequest
{
    /**
     * @param OfferType $type Тип акции (Original — обычная, PersonalGoods — персональные товары, PersonalOffer — персональное предложение, All — все)
     * @param positive-int|null $merchantId Внутренний идентификатор магазина (торговой точки) торговой точки
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     */
    public function __construct(
        #[SerializedName('filter.type')]
        public OfferType $type,
        #[SerializedName('filter.merchantId')]
        public ?int $merchantId,
        #[SerializedName('filter.from')]
        public int $from,
        #[SerializedName('filter.count')]
        public int $count,
    ) {
        if ($this->merchantId !== null) {
            Assert::positiveInteger($this->merchantId);
        }

        Assert::natural($this->from);
        Assert::positiveInteger($this->count);
    }
}
