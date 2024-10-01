<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Merchants\Response\Merchant;
use Studio15\Loymax\PublicApi\Offer\GetMerchantsByOfferId;
use Studio15\Loymax\PublicApi\Offer\GetOffer;
use Studio15\Loymax\PublicApi\Offer\GetOfferById;
use Studio15\Loymax\PublicApi\Offer\Request\GetMerchantsByOfferIdRequest;
use Studio15\Loymax\PublicApi\Offer\Request\GetOfferByIdRequest;
use Studio15\Loymax\PublicApi\Offer\Request\GetOfferRequest;
use Studio15\Loymax\PublicApi\Offer\Request\OfferType;
use Studio15\Loymax\PublicApi\Offer\Response\Offer as OfferData;

/**
 * Offer. Методы для работы с таргетированным контентом
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/
 */
final readonly class Offer
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о таргетированном контенте
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243044043343544243844043E43243043D43D43E43C43A43E43D44243543D442435
     *
     * @param OfferType $type Тип акции (Original — обычная, PersonalGoods — персональные товары, PersonalOffer — персональное предложение, All — все)
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     * @param positive-int|null $merchantId Внутренний идентификатор магазина (торговой точки)
     *
     * @return list<OfferData>
     *
     * @throws DenormalizeResponseError
     */
    public function getOffer(
        OfferType $type = OfferType::All,
        int $from = 0,
        int $count = 10,
        ?int $merchantId = null,
    ): array {
        $pagination = new Pagination(
            from: $from,
            count: $count,
        );

        $request = new GetOfferRequest(
            type: $type,
            pagination: $pagination,
            merchantId: $merchantId,
        );

        $getOfferList = new GetOffer(
            apiClient: $this->apiClient,
        );

        return ($getOfferList)(
            request: $request,
        );
    }

    /**
     * Возвращает информацию о таргетированном контенте по внутреннему идентификатору
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243044043343544243844043E43243043D43D43E43C43A43E43D44243543D44243543F43E43243D44344244043543D43D43543C44343843443543D44243844443843A43044243E440443
     *
     * @param positive-int $offerId Внутренний идентификатор таргетированного контента
     *
     * @throws DenormalizeResponseError
     */
    public function getOfferById(int $offerId): OfferData
    {
        $request = new GetOfferByIdRequest(
            offerId: $offerId,
        );

        $getOfferById = new GetOfferById(
            apiClient: $this->apiClient,
        );

        return ($getOfferById)(
            request: $request,
        );
    }

    /**
     * Возвращает список магазинов (торговых точек), для которых действует таргетированный контент
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544244143F43844143E43A43C43043343043743843D43E4322844243E44043343E43244B44544243E44743543A292C43443B44F43A43E44243E44044B44543443543944144243244343544244243044043343544243844043E43243043D43D44B43943A43E43D44243543D442
     *
     * @param positive-int $offerId Внутренний идентификатор таргетированного контента
     *
     * @return list<Merchant>
     *
     * @throws DenormalizeResponseError
     */
    public function getMerchantsByOfferId(int $offerId): array
    {
        $request = new GetMerchantsByOfferIdRequest(
            offerId: $offerId,
        );

        $getMerchantList = new GetMerchantsByOfferId(
            apiClient: $this->apiClient,
        );

        return ($getMerchantList)(
            request: $request,
        );
    }
}
