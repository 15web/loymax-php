<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\Response\GetEmitVirtualResponse;

/**
 * Возвращает информацию о возможности выпуска виртуальной карты
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43243E43743C43E43643D43E44144243843244B43F44344143A43043243844044244343043B44C43D43E43943A43044044244B
 */
final readonly class GetEmitVirtual
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): GetEmitVirtualResponse
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/Cards/EmitVirtual',
        );

        /** @var GetEmitVirtualResponse $getEmitVirtualResponse */
        $getEmitVirtualResponse = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: GetEmitVirtualResponse::class,
        );

        return $getEmitVirtualResponse;
    }
}
