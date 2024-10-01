<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Request;

/**
 * Запрос на получение списка магазинов (торговых точек), для которых действует таргетированный контент
 *
 * @internal
 */
final readonly class GetMerchantsByOfferIdRequest
{
    /**
     * @param positive-int $offerId Внутренний идентификатор таргетированного контента
     */
    public function __construct(
        public int $offerId,
    ) {}
}
