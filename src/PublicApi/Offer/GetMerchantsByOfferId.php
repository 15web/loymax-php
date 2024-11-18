<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Merchants\Response\Merchant;
use Studio15\Loymax\PublicApi\Offer\Request\GetMerchantsByOfferIdRequest;

/**
 * Возвращает список магазинов (торговых точек), для которых действует таргетированный контент
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544244143F43844143E43A43C43043343043743843D43E4322844243E44043343E43244B44544243E44743543A292C43443B44F43A43E44243E44044B44543443543944144243244343544244243044043343544243844043E43243043D43D44B43943A43E43D44243543D442
 */
final readonly class GetMerchantsByOfferId
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Merchant>
     *
     * @throws ApiClientException
     */
    public function __invoke(GetMerchantsByOfferIdRequest $request): array
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: "/publicapi/v1.2/Offer/{$request->offerId}/merchants",
        );

        /** @var list<Merchant> $merchantList */
        $merchantList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Merchant::class.'[]',
        );

        return $merchantList;
    }
}
