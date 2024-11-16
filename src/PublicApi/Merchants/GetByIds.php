<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Merchants\Request\GetByIdsRequest;
use Studio15\Loymax\PublicApi\Merchants\Response\Merchant;

/**
 * Возвращает информацию о торговых точках (фильтр по внутренним идентификаторам торговых точек)
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243E44043343E43244B44544243E44743A4304452844443843B44C44244043F43E43243D44344244043543D43D43843C43843443543D44243844443843A43044243E44043043C44243E44043343E43244B44544243E44743543A29
 */
final readonly class GetByIds
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Merchant>
     *
     * @throws ApiClientException
     */
    public function __invoke(GetByIdsRequest $parameters): array
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/Merchants',
            parameters: $parameters,
        );

        /** @var list<Merchant> $merchantList */
        $merchantList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Merchant::class.'[]',
        );

        return $merchantList;
    }
}
