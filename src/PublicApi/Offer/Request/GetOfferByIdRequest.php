<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Request;

/**
 * Запрос на получение информации о таргетированном контенте по внутреннему идентификатору
 *
 * @internal
 */
final readonly class GetOfferByIdRequest
{
    /**
     * @param positive-int $offerId Внутренний идентификатор таргетированного контента
     */
    public function __construct(
        public int $offerId,
    ) {}
}
