<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Merchants\Request\GetByUidsRequest;
use Studio15\Loymax\PublicApi\Merchants\Response\Merchant;
use Throwable;

/**
 * Возвращает информацию о торговых точках (фильтр по внешним идентификаторам торговых точек)
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243E44043343E43244B44544243E44743A4304452844443843B44C44244043F43E43243D43544843D43843C43843443543D44243844443843A43044243E44043043C44243E44043343E43244B44544243E44743543A29
 *
 * @internal
 */
final readonly class GetByUids
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Merchant>
     */
    public function __invoke(GetByUidsRequest $request, Pagination $pagination): array
    {
        $parameters = [
            'merchantsUids' => $request->merchantsUids,
            'from' => $pagination->from,
            'count' => $pagination->count,
        ];

        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Merchants/ByUids',
            parameters: $parameters,
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var list<Merchant> $merchantList */
            $merchantList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Merchant::class.'[]',
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $merchantList;
    }
}
