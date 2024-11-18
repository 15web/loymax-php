<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Offer\Request\GetOfferRequest;
use Studio15\Loymax\PublicApi\Offer\Response\Offer;

/**
 * Возвращает информацию о таргетированном контенте
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243044043343544243844043E43243043D43D43E43C43A43E43D44243543D442435
 */
final readonly class GetOffer
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Offer>
     *
     * @throws ApiClientException
     */
    public function __invoke(GetOfferRequest $parameters): array
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/Offer',
            parameters: $parameters,
        );

        /** @var list<Offer> $offerList */
        $offerList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Offer::class.'[]',
        );

        return $offerList;
    }
}
