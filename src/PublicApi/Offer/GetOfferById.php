<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Offer\Request\GetOfferByIdRequest;
use Studio15\Loymax\PublicApi\Offer\Response\Offer;
use Throwable;

/**
 * Возвращает информацию о таргетированном контенте по внутреннему идентификатору
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243044043343544243844043E43243043D43D43E43C43A43E43D44243543D44243543F43E43243D44344244043543D43D43543C44343843443543D44243844443843A43044243E440443
 */
final readonly class GetOfferById
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(GetOfferByIdRequest $request): Offer
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: "/publicapi/v1.2/Offer/{$request->offerId}",
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var Offer $offer */
            $offer = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Offer::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $offer;
    }
}
