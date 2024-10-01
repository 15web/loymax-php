<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Request;

use Studio15\Loymax\PublicApi\Data\Pagination;

/**
 * Запрос на получение информации о таргетированном контенте
 *
 * @internal
 */
final readonly class GetOfferRequest
{
    /**
     * @param OfferType $type Тип акции (Original — обычная, PersonalGoods — персональные товары, PersonalOffer — персональное предложение, All — все)
     * @param positive-int|null $merchantId Внутренний идентификатор магазина (торговой точки) торговой точки
     */
    public function __construct(
        public OfferType $type,
        public Pagination $pagination,
        public ?int $merchantId = null,
    ) {}
}
